/*!
 * Autolinker.js
 * 0.25.0
 *
 * Copyright(c) 2016 Gregory Jacobs <greg@greg-jacobs.com>
 * MIT License
 *
 * https://github.com/gregjacobs/Autolinker.js
 */
;(function(root, factory) {
  if (typeof define === 'function' && define.amd) {
    define([], factory);
  } else if (typeof exports === 'object') {
    module.exports = factory();
  } else {
    root.Autolinker = factory();
  }
}(this, function() {
/**
 * @class Autolinker
 * @extends Object
 *
 * Utility class used to process a given string of text, and wrap the matches in
 * the appropriate anchor (&lt;a&gt;) tags to turn them into links.
 *
 * Any of the configuration options may be provided in an Object (map) provided
 * to the Autolinker constructor, which will configure how the {@link #link link()}
 * method will process the links.
 *
 * For example:
 *
 *     var autolinker = new Autolinker( {
 *         newWindow : false,
 *         truncate  : 30
 *     } );
 *
 *     var html = autolinker.link( "Joe went to www.yahoo.com" );
 *     // produces: 'Joe went to <a href="http://www.yahoo.com">yahoo.com</a>'
 *
 *
 * The {@link #static-link static link()} method may also be used to inline
 * options into a single call, which may be more convenient for one-off uses.
 * For example:
 *
 *     var html = Autolinker.link( "Joe went to www.yahoo.com", {
 *         newWindow : false,
 *         truncate  : 30
 *     } );
 *     // produces: 'Joe went to <a href="http://www.yahoo.com">yahoo.com</a>'
 *
 *
 * ## Custom Replacements of Links
 *
 * If the configuration options do not provide enough flexibility, a {@link #replaceFn}
 * may be provided to fully customize the output of Autolinker. This function is
 * called once for each URL/Email/Phone#/Twitter Handle/Hashtag match that is
 * encountered.
 *
 * For example:
 *
 *     var input = "...";  // string with URLs, Email Addresses, Phone #s, Twitter Handles, and Hashtags
 *
 *     var linkedText = Autolinker.link( input, {
 *         replaceFn : function( autolinker, match ) {
 *             console.log( "href = ", match.getAnchorHref() );
 *             console.log( "text = ", match.getAnchorText() );
 *
 *             switch( match.getType() ) {
 *                 case 'url' :
 *                     console.log( "url: ", match.getUrl() );
 *
 *                     if( match.getUrl().indexOf( 'mysite.com' ) === -1 ) {
 *                         var tag = autolinker.getTagBuilder().build( match );  // returns an `Autolinker.HtmlTag` instance, which provides mutator methods for easy changes
 *                         tag.setAttr( 'rel', 'nofollow' );
 *                         tag.addClass( 'external-link' );
 *
 *                         return tag;
 *
 *                     } else {
 *                         return true;  // let Autolinker perform its normal anchor tag replacement
 *                     }
 *
 *                 case 'email' :
 *                     var email = match.getEmail();
 *                     console.log( "email: ", email );
 *
 *                     if( email === "my@own.address" ) {
 *                         return false;  // don't auto-link this particular email address; leave as-is
 *                     } else {
 *                         return;  // no return value will have Autolinker perform its normal anchor tag replacement (same as returning `true`)
 *                     }
 *
 *                 case 'phone' :
 *                     var phoneNumber = match.getPhoneNumber();
 *                     console.log( phoneNumber );
 *
 *                     return '<a href="http://newplace.to.link.phone.numbers.to/">' + phoneNumber + '</a>';
 *
 *                 case 'twitter' :
 *                     var twitterHandle = match.getTwitterHandle();
 *                     console.log( twitterHandle );
 *
 *                     return '<a href="http://newplace.to.link.twitter.handles.to/">' + twitterHandle + '</a>';
 *
 *                 case 'hashtag' :
 *                     var hashtag = match.getHashtag();
 *                     console.log( hashtag );
 *
 *                     return '<a href="http://newplace.to.link.hashtag.handles.to/">' + hashtag + '</a>';
 *             }
 *         }
 *     } );
 *
 *
 * The function may return the following values:
 *
 * - `true` (Boolean): Allow Autolinker to replace the match as it normally
 *   would.
 * - `false` (Boolean): Do not replace the current match at all - leave as-is.
 * - Any String: If a string is returned from the function, the string will be
 *   used directly as the replacement HTML for the match.
 * - An {@link Autolinker.HtmlTag} instance, which can be used to build/modify
 *   an HTML tag before writing out its HTML text.
 *
 * @constructor
 * @param {Object} [cfg] The configuration options for the Autolinker instance,
 *   specified in an Object (map).
 */
var Autolinker = function( cfg ) {
	cfg = cfg || {};

	this.urls = this.normalizeUrlsCfg( cfg.urls );
	this.email = typeof cfg.email === 'boolean' ? cfg.email : true;
	this.twitter = typeof cfg.twitter === 'boolean' ? cfg.twitter : true;
	this.phone = typeof cfg.phone === 'boolean' ? cfg.phone : true;
	this.hashtag = cfg.hashtag || false;
	this.newWindow = typeof cfg.newWindow === 'boolean' ? cfg.newWindow : true;
	this.stripPrefix = typeof cfg.stripPrefix === 'boolean' ? cfg.stripPrefix : true;

	// Validate the value of the `hashtag` cfg.
	var hashtag = this.hashtag;
	if( hashtag !== false && hashtag !== 'twitter' && hashtag !== 'facebook' && hashtag !== 'instagram' ) {
		throw new Error( "invalid `hashtag` cfg - see docs" );
	}

	this.truncate = this.normalizeTruncateCfg( cfg.truncate );
	this.className = cfg.className || '';
	this.replaceFn = cfg.replaceFn || null;

	this.htmlParser = null;
	this.matchers = null;
	this.tagBuilder = null;
};

Autolinker.prototype = {
	constructor : Autolinker,  // fix constructor property

	/**
	 * @cfg {Boolean/Object} [urls=true]
	 *
	 * `true` if URLs should be automatically linked, `false` if they should not
	 * be.
	 *
	 * This option also accepts an Object form with 3 properties, to allow for
	 * more customization of what exactly gets linked. All default to `true`:
	 *
	 * @param {Boolean} schemeMatches `true` to match URLs found prefixed with a
	 *   scheme, i.e. `http://google.com`, or `other+scheme://google.com`,
	 *   `false` to prevent these types of matches.
	 * @param {Boolean} wwwMatches `true` to match urls found prefixed with
	 *   `'www.'`, i.e. `www.google.com`. `false` to prevent these types of
	 *   matches. Note that if the URL had a prefixed scheme, and
	 *   `schemeMatches` is true, it will still be linked.
	 * @param {Boolean} tldMatches `true` to match URLs with known top level
	 *   domains (.com, .net, etc.) that are not prefixed with a scheme or
	 *   `'www.'`. This option attempts to match anything that looks like a URL
	 *   in the given text. Ex: `google.com`, `asdf.org/?page=1`, etc. `false`
	 *   to prevent these types of matches.
	 */

	/**
	 * @cfg {Boolean} [email=true]
	 *
	 * `true` if email addresses should be automatically linked, `false` if they
	 * should not be.
	 */

	/**
	 * @cfg {Boolean} [twitter=true]
	 *
	 * `true` if Twitter handles ("@example") should be automatically linked,
	 * `false` if they should not be.
	 */

	/**
	 * @cfg {Boolean} [phone=true]
	 *
	 * `true` if Phone numbers ("(555)555-5555") should be automatically linked,
	 * `false` if they should not be.
	 */

	/**
	 * @cfg {Boolean/String} [hashtag=false]
	 *
	 * A string for the service name to have hashtags (ex: "#myHashtag")
	 * auto-linked to. The currently-supported values are:
	 *
	 * - 'twitter'
	 * - 'facebook'
	 * - 'instagram'
	 *
	 * Pass `false` to skip auto-linking of hashtags.
	 */

	/**
	 * @cfg {Boolean} [newWindow=true]
	 *
	 * `true` if the links should open in a new window, `false` otherwise.
	 */

	/**
	 * @cfg {Boolean} [stripPrefix=true]
	 *
	 * `true` if 'http://' or 'https://' and/or the 'www.' should be stripped
	 * from the beginning of URL links' text, `false` otherwise.
	 */

	/**
	 * @cfg {Number/Object} truncate
	 *
	 * ## Number Form
	 *
	 * A number for how many characters matched text should be truncated to
	 * inside the text of a link. If the matched text is over this number of
	 * characters, it will be truncated to this length by adding a two period
	 * ellipsis ('..') to the end of the string.
	 *
	 * For example: A url like 'http://www.yahoo.com/some/long/path/to/a/file'
	 * truncated to 25 characters might look something like this:
	 * 'yahoo.com/some/long/pat..'
	 *
	 * Example Usage:
	 *
	 *     truncate: 25
	 *
	 *
	 * ## Object Form
	 *
	 * An Object may also be provided with two properties: `length` (Number) and
	 * `location` (String). `location` may be one of the following: 'end'
	 * (default), 'middle', or 'smart'.
	 *
	 * Example Usage:
	 *
	 *     truncate: { length: 25, location: 'middle' }
	 *
	 * @cfg {Number} truncate.length How many characters to allow before
	 *   truncation will occur.
	 * @cfg {"end"/"middle"/"smart"} [truncate.location="end"]
	 *
	 * - 'end' (default): will truncate up to the number of characters, and then
	 *   add an ellipsis at the end. Ex: 'yahoo.com/some/long/pat..'
	 * - 'middle': will truncate and add the ellipsis in the middle. Ex:
	 *   'yahoo.com/s..th/to/a/file'
	 * - 'smart': for URLs where the algorithm attempts to strip out unnecessary
	 *   parts first (such as the 'www.', then URL scheme, hash, etc.),
	 *   attempting to make the URL human-readable before looking for a good
	 *   point to insert the ellipsis if it is still too long. Ex:
	 *   'yahoo.com/some..to/a/file'. For more details, see
	 *   {@link Autolinker.truncate.TruncateSmart}.
	 */

	/**
	 * @cfg {String} className
	 *
	 * A CSS class name to add to the generated links. This class will be added
	 * to all links, as well as this class plus match suffixes for styling
	 * url/email/phone/twitter/hashtag links differently.
	 *
	 * For example, if this config is provided as "myLink", then:
	 *
	 * - URL links will have the CSS classes: "myLink myLink-url"
	 * - Email links will have the CSS classes: "myLink myLink-email", and
	 * - Twitter links will have the CSS classes: "myLink myLink-twitter"
	 * - Phone links will have the CSS classes: "myLink myLink-phone"
	 * - Hashtag links will have the CSS classes: "myLink myLink-hashtag"
	 */

	/**
	 * @cfg {Function} replaceFn
	 *
	 * A function to individually process each match found in the input string.
	 *
	 * See the class's description for usage.
	 *
	 * This function is called with the following parameters:
	 *
	 * @cfg {Autolinker} replaceFn.autolinker The Autolinker instance, which may
	 *   be used to retrieve child objects from (such as the instance's
	 *   {@link #getTagBuilder tag builder}).
	 * @cfg {Autolinker.match.Match} replaceFn.match The Match instance which
	 *   can be used to retrieve information about the match that the `replaceFn`
	 *   is currently processing. See {@link Autolinker.match.Match} subclasses
	 *   for details.
	 */


	/**
	 * @private
	 * @property {Autolinker.htmlParser.HtmlParser} htmlParser
	 *
	 * The HtmlParser instance used to skip over HTML tags, while finding text
	 * nodes to process. This is lazily instantiated in the {@link #getHtmlParser}
	 * method.
	 */

	/**
	 * @private
	 * @property {Autolinker.matcher.Matcher[]} matchers
	 *
	 * The {@link Autolinker.matcher.Matcher} instances for this Autolinker
	 * instance.
	 *
	 * This is lazily created in {@link #getMatchers}.
	 */

	/**
	 * @private
	 * @property {Autolinker.AnchorTagBuilder} tagBuilder
	 *
	 * The AnchorTagBuilder instance used to build match replacement anchor tags.
	 * Note: this is lazily instantiated in the {@link #getTagBuilder} method.
	 */


	/**
	 * Normalizes the {@link #urls} config into an Object with 3 properties:
	 * `schemeMatches`, `wwwMatches`, and `tldMatches`, all Booleans.
	 *
	 * See {@link #urls} config for details.
	 *
	 * @private
	 * @param {Boolean/Object} urls
	 * @return {Object}
	 */
	normalizeUrlsCfg : function( urls ) {
		if( urls == null ) urls = true;  // default to `true`

		if( typeof urls === 'boolean' ) {
			return { schemeMatches: urls, wwwMatches: urls, tldMatches: urls };

		} else {  // object form
			return {
				schemeMatches : typeof urls.schemeMatches === 'boolean' ? urls.schemeMatches : true,
				wwwMatches    : typeof urls.wwwMatches === 'boolean'    ? urls.wwwMatches    : true,
				tldMatches    : typeof urls.tldMatches === 'boolean'    ? urls.tldMatches    : true
			};
		}
	},


	/**
	 * Normalizes the {@link #truncate} config into an Object with 2 properties:
	 * `length` (Number), and `location` (String).
	 *
	 * See {@link #truncate} config for details.
	 *
	 * @private
	 * @param {Number/Object} truncate
	 * @return {Object}
	 */
	normalizeTruncateCfg : function( truncate ) {
		if( typeof truncate === 'number' ) {
			return { length: truncate, location: 'end' };

		} else {  // object, or undefined/null
			return Autolinker.Util.defaults( truncate || {}, {
				length   : Number.POSITIVE_INFINITY,
				location : 'end'
			} );
		}
	},


	/**
	 * Parses the input `textOrHtml` looking for URLs, email addresses, phone
	 * numbers, username handles, and hashtags (depending on the configuration
	 * of the Autolinker instance), and returns an array of {@link Autolinker.match.Match}
	 * objects describing those matches.
	 *
	 * This method is used by the {@link #link} method, but can also be used to
	 * simply do parsing of the input in order to discover what kinds of links
	 * there are and how many.
	 *
	 * @param {String} textOrHtml The HTML or text to find matches within
	 *   (depending on if the {@link #urls}, {@link #email}, {@link #phone},
	 *   {@link #twitter}, and {@link #hashtag} options are enabled).
	 * @return {Autolinker.match.Match[]} The array of Matches found in the
	 *   given input `textOrHtml`.
	 */
	parse : function( textOrHtml ) {
		var htmlParser = this.getHtmlParser(),
		    htmlNodes = htmlParser.parse( textOrHtml ),
		    anchorTagStackCount = 0,  // used to only process text around anchor tags, and any inner text/html they may have;
		    matches = [];

		// Find all matches within the `textOrHtml` (but not matches that are
		// already nested within <a> tags)
		for( var i = 0, len = htmlNodes.length; i < len; i++ ) {
			var node = htmlNodes[ i ],
			    nodeType = node.getType();

			if( nodeType === 'element' && node.getTagName() === 'a' ) {  // Process HTML anchor element nodes in the input `textOrHtml` to find out when we're within an <a> tag
				if( !node.isClosing() ) {  // it's the start <a> tag
					anchorTagStackCount++;
				} else {  // it's the end </a> tag
					anchorTagStackCount = Math.max( anchorTagStackCount - 1, 0 );  // attempt to handle extraneous </a> tags by making sure the stack count never goes below 0
				}

			} else if( nodeType === 'text' && anchorTagStackCount === 0 ) {  // Process text nodes that are not within an <a> tag
				var textNodeMatches = this.parseText( node.getText(), node.getOffset() );

				matches.push.apply( matches, textNodeMatches );
			}
		}


		// After we have found all matches, remove subsequent matches that
		// overlap with a previous match. This can happen for instance with URLs,
		// where the url 'google.com/#link' would match '#link' as a hashtag.
		matches = this.compactMatches( matches );

		// And finally, remove matches for match types that have been turned
		// off. We needed to have all match types turned on initially so that
		// things like hashtags could be filtered out if they were really just
		// part of a URL match (for instance, as a named anchor).
		matches = this.removeUnwantedMatches( matches );

		return matches;
	},


	/**
	 * After we have found all matches, we need to remove subsequent matches
	 * that overlap with a previous match. This can happen for instance with
	 * URLs, where the url 'google.com/#link' would match '#link' as a hashtag.
	 *
	 * @private
	 * @param {Autolinker.match.Match[]} matches
	 * @return {Autolinker.match.Match[]}
	 */
	compactMatches : function( matches ) {
		// First, the matches need to be sorted in order of offset
		matches.sort( function( a, b ) { return a.getOffset() - b.getOffset(); } );

		for( var i = 0; i < matches.length - 1; i++ ) {
			var match = matches[ i ],
			    endIdx = match.getOffset() + match.getMatchedText().length;

			// Remove subsequent matches that overlap with the current match
			while( i + 1 < matches.length && matches[ i + 1 ].getOffset() <= endIdx ) {
				matches.splice( i + 1, 1 );
			}
		}

		return matches;
	},


	/**
	 * Removes matches for matchers that were turned off in the options. For
	 * example, if {@link #hashtag hashtags} were not to be matched, we'll
	 * remove them from the `matches` array here.
	 *
	 * @private
	 * @param {Autolinker.match.Match[]} matches The array of matches to remove
	 *   the unwanted matches from. Note: this array is mutated for the
	 *   removals.
	 * @return {Autolinker.match.Match[]} The mutated input `matches` array.
	 */
	removeUnwantedMatches : function( matches ) {
		var remove = Autolinker.Util.remove;

		if( !this.hashtag ) remove( matches, function( match ) { return match.getType() === 'hashtag'; } );
		if( !this.email )   remove( matches, function( match ) { return match.getType() === 'email'; } );
		if( !this.phone )   remove( matches, function( match ) { return match.getType() === 'phone'; } );
		if( !this.twitter ) remove( matches, function( match ) { return match.getType() === 'twitter'; } );
		if( !this.urls.schemeMatches ) {
			remove( matches, function( m ) { return m.getType() === 'url' && m.getUrlMatchType() === 'scheme'; } );
		}
		if( !this.urls.wwwMatches ) {
			remove( matches, function( m ) { return m.getType() === 'url' && m.getUrlMatchType() === 'www'; } );
		}
		if( !this.urls.tldMatches ) {
			remove( matches, function( m ) { return m.getType() === 'url' && m.getUrlMatchType() === 'tld'; } );
		}

		return matches;
	},


	/**
	 * Parses the input `text` looking for URLs, email addresses, phone
	 * numbers, username handles, and hashtags (depending on the configuration
	 * of the Autolinker instance), and returns an array of {@link Autolinker.match.Match}
	 * objects describing those matches.
	 *
	 * This method processes a **non-HTML string**, and is used to parse and
	 * match within the text nodes of an HTML string. This method is used
	 * internally by {@link #parse}.
	 *
	 * @private
	 * @param {String} text The text to find matches within (depending on if the
	 *   {@link #urls}, {@link #email}, {@link #phone}, {@link #twitter}, and
	 *   {@link #hashtag} options are enabled). This must be a non-HTML string.
	 * @param {Number} [offset=0] The offset of the text node within the
	 *   original string. This is used when parsing with the {@link #parse}
	 *   method to generate correct offsets within the {@link Autolinker.match.Match}
	 *   instances, but may be omitted if calling this method publicly.
	 * @return {Autolinker.match.Match[]} The array of Matches found in the
	 *   given input `text`.
	 */
	parseText : function( text, offset ) {
		offset = offset || 0;
		var matchers = this.getMatchers(),
		    matches = [];

		for( var i = 0, numMatchers = matchers.length; i < numMatchers; i++ ) {
			var textMatches = matchers[ i ].parseMatches( text );

			// Correct the offset of each of the matches. They are originally
			// the offset of the match within the provided text node, but we
			// need to correct them to be relative to the original HTML input
			// string (i.e. the one provided to #parse).
			for( var j = 0, numTextMatches = textMatches.length; j < numTextMatches; j++ ) {
				textMatches[ j ].setOffset( offset + textMatches[ j ].getOffset() );
			}

			matches.push.apply( matches, textMatches );
		}
		return matches;
	},


	/**
	 * Automatically links URLs, Email addresses, Phone numbers, Twitter
	 * handles, and Hashtags found in the given chunk of HTML. Does not link
	 * URLs found within HTML tags.
	 *
	 * For instance, if given the text: `You should go to http://www.yahoo.com`,
	 * then the result will be `You should go to
	 * &lt;a href="http://www.yahoo.com"&gt;http://www.yahoo.com&lt;/a&gt;`
	 *
	 * This method finds the text around any HTML elements in the input
	 * `textOrHtml`, which will be the text that is processed. Any original HTML
	 * elements will be left as-is, as well as the text that is already wrapped
	 * in anchor (&lt;a&gt;) tags.
	 *
	 * @param {String} textOrHtml The HTML or text to autolink matches within
	 *   (depending on if the {@link #urls}, {@link #email}, {@link #phone},
	 *   {@link #twitter}, and {@link #hashtag} options are enabled).
	 * @return {String} The HTML, with matches automatically linked.
	 */
	link : function( textOrHtml ) {
		if( !textOrHtml ) { return ""; }  // handle `null` and `undefined`

		var matches = this.parse( textOrHtml ),
			newHtml = [],
			lastIndex = 0;

		for( var i = 0, len = matches.length; i < len; i++ ) {
			var match = matches[ i ];

			newHtml.push( textOrHtml.substring( lastIndex, match.getOffset() ) );
			newHtml.push( this.createMatchReturnVal( match ) );

			lastIndex = match.getOffset() + match.getMatchedText().length;
		}
		newHtml.push( textOrHtml.substring( lastIndex ) );  // handle the text after the last match

		return newHtml.join( '' );
	},


	/**
	 * Creates the return string value for a given match in the input string.
	 *
	 * This method handles the {@link #replaceFn}, if one was provided.
	 *
	 * @private
	 * @param {Autolinker.match.Match} match The Match object that represents
	 *   the match.
	 * @return {String} The string that the `match` should be replaced with.
	 *   This is usually the anchor tag string, but may be the `matchStr` itself
	 *   if the match is not to be replaced.
	 */
	createMatchReturnVal : function( match ) {
		// Handle a custom `replaceFn` being provided
		var replaceFnResult;
		if( this.replaceFn ) {
			replaceFnResult = this.replaceFn.call( this, this, match );  // Autolinker instance is the context, and the first arg
		}

		if( typeof replaceFnResult === 'string' ) {
			return replaceFnResult;  // `replaceFn` returned a string, use that

		} else if( replaceFnResult === false ) {
			return match.getMatchedText();  // no replacement for the match

		} else if( replaceFnResult instanceof Autolinker.HtmlTag ) {
			return replaceFnResult.toAnchorString();

		} else {  // replaceFnResult === true, or no/unknown return value from function
			// Perform Autolinker's default anchor tag generation
			var anchorTag = match.buildTag();  // returns an Autolinker.HtmlTag instance

			return anchorTag.toAnchorString();
		}
	},


	/**
	 * Lazily instantiates and returns the {@link #htmlParser} instance for this
	 * Autolinker instance.
	 *
	 * @protected
	 * @return {Autolinker.htmlParser.HtmlParser}
	 */
	getHtmlParser : function() {
		var htmlParser = this.htmlParser;

		if( !htmlParser ) {
			htmlParser = this.htmlParser = new Autolinker.htmlParser.HtmlParser();
		}

		return htmlParser;
	},


	/**
	 * Lazily instantiates and returns the {@link Autolinker.matcher.Matcher}
	 * instances for this Autolinker instance.
	 *
	 * @protected
	 * @return {Autolinker.matcher.Matcher[]}
	 */
	getMatchers : function() {
		if( !this.matchers ) {
			var matchersNs = Autolinker.matcher,
			    tagBuilder = this.getTagBuilder();

			var matchers = [
				new matchersNs.Hashtag( { tagBuilder: tagBuilder, serviceName: this.hashtag } ),
				new matchersNs.Email( { tagBuilder: tagBuilder } ),
				new matchersNs.Phone( { tagBuilder: tagBuilder } ),
				new matchersNs.Twitter( { tagBuilder: tagBuilder } ),
				new matchersNs.Url( { tagBuilder: tagBuilder, stripPrefix: this.stripPrefix } )
			];

			return ( this.matchers = matchers );

		} else {
			return this.matchers;
		}
	},


	/**
	 * Returns the {@link #tagBuilder} instance for this Autolinker instance, lazily instantiating it
	 * if it does not yet exist.
	 *
	 * This method may be used in a {@link #replaceFn} to generate the {@link Autolinker.HtmlTag HtmlTag} instance that
	 * Autolinker would normally generate, and then allow for modifications before returning it. For example:
	 *
	 *     var html = Autolinker.link( "Test google.com", {
	 *         replaceFn : function( autolinker, match ) {
	 *             var tag = autolinker.getTagBuilder().build( match );  // returns an {@link Autolinker.HtmlTag} instance
	 *             tag.setAttr( 'rel', 'nofollow' );
	 *
	 *             return tag;
	 *         }
	 *     } );
	 *
	 *     // generated html:
	 *     //   Test <a href="http://google.com" target="_blank" rel="nofollow">google.com</a>
	 *
	 * @return {Autolinker.AnchorTagBuilder}
	 */
	getTagBuilder : function() {
		var tagBuilder = this.tagBuilder;

		if( !tagBuilder ) {
			tagBuilder = this.tagBuilder = new Autolinker.AnchorTagBuilder( {
				newWindow   : this.newWindow,
				truncate    : this.truncate,
				className   : this.className
			} );
		}

		return tagBuilder;
	}

};


/**
 * Automatically links URLs, Email addresses, Phone Numbers, Twitter handles,
 * and Hashtags found in the given chunk of HTML. Does not link URLs found
 * within HTML tags.
 *
 * For instance, if given the text: `You should go to http://www.yahoo.com`,
 * then the result will be `You should go to &lt;a href="http://www.yahoo.com"&gt;http://www.yahoo.com&lt;/a&gt;`
 *
 * Example:
 *
 *     var linkedText = Autolinker.link( "Go to google.com", { newWindow: false } );
 *     // Produces: "Go to <a href="http://google.com">google.com</a>"
 *
 * @static
 * @param {String} textOrHtml The HTML or text to find matches within (depending
 *   on if the {@link #urls}, {@link #email}, {@link #phone}, {@link #twitter},
 *   and {@link #hashtag} options are enabled).
 * @param {Object} [options] Any of the configuration options for the Autolinker
 *   class, specified in an Object (map). See the class description for an
 *   example call.
 * @return {String} The HTML text, with matches automatically linked.
 */
Autolinker.link = function( textOrHtml, options ) {
	var autolinker = new Autolinker( options );
	return autolinker.link( textOrHtml );
};


// Autolinker Namespaces

Autolinker.match = {};
Autolinker.matcher = {};
Autolinker.htmlParser = {};
Autolinker.truncate = {};

/*global Autolinker */
/*jshint eqnull:true, boss:true */
/**
 * @class Autolinker.Util
 * @singleton
 *
 * A few utility methods for Autolinker.
 */
Autolinker.Util = {

	/**
	 * @property {Function} abstractMethod
	 *
	 * A function object which represents an abstract method.
	 */
	abstractMethod : function() { throw "abstract"; },


	/**
	 * @private
	 * @property {RegExp} trimRegex
	 *
	 * The regular expression used to trim the leading and trailing whitespace
	 * from a string.
	 */
	trimRegex : /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g,


	/**
	 * Assigns (shallow copies) the properties of `src` onto `dest`.
	 *
	 * @param {Object} dest The destination object.
	 * @param {Object} src The source object.
	 * @return {Object} The destination object (`dest`)
	 */
	assign : function( dest, src ) {
		for( var prop in src ) {
			if( src.hasOwnProperty( prop ) ) {
				dest[ prop ] = src[ prop ];
			}
		}

		return dest;
	},


	/**
	 * Assigns (shallow copies) the properties of `src` onto `dest`, if the
	 * corresponding property on `dest` === `undefined`.
	 *
	 * @param {Object} dest The destination object.
	 * @param {Object} src The source object.
	 * @return {Object} The destination object (`dest`)
	 */
	defaults : function( dest, src ) {
		for( var prop in src ) {
			if( src.hasOwnProperty( prop ) && dest[ prop ] === undefined ) {
				dest[ prop ] = src[ prop ];
			}
		}

		return dest;
	},


	/**
	 * Extends `superclass` to create a new subclass, adding the `protoProps` to the new subclass's prototype.
	 *
	 * @param {Function} superclass The constructor function for the superclass.
	 * @param {Object} protoProps The methods/properties to add to the subclass's prototype. This may contain the
	 *   special property `constructor`, which will be used as the new subclass's constructor function.
	 * @return {Function} The new subclass function.
	 */
	extend : function( superclass, protoProps ) {
		var superclassProto = superclass.prototype;

		var F = function() {};
		F.prototype = superclassProto;

		var subclass;
		if( protoProps.hasOwnProperty( 'constructor' ) ) {
			subclass = protoProps.constructor;
		} else {
			subclass = function() { superclassProto.constructor.apply( this, arguments ); };
		}

		var subclassProto = subclass.prototype = new F();  // set up prototype chain
		subclassProto.constructor = subclass;  // fix constructor property
		subclassProto.superclass = superclassProto;

		delete protoProps.constructor;  // don't re-assign constructor property to the prototype, since a new function may have been created (`subclass`), which is now already there
		Autolinker.Util.assign( subclassProto, protoProps );

		return subclass;
	},


	/**
	 * Truncates the `str` at `len - ellipsisChars.length`, and adds the `ellipsisChars` to the
	 * end of the string (by default, two periods: '..'). If the `str` length does not exceed
	 * `len`, the string will be returned unchanged.
	 *
	 * @param {String} str The string to truncate and add an ellipsis to.
	 * @param {Number} truncateLen The length to truncate the string at.
	 * @param {String} [ellipsisChars=..] The ellipsis character(s) to add to the end of `str`
	 *   when truncated. Defaults to '..'
	 */
	ellipsis : function( str, truncateLen, ellipsisChars ) {
		if( str.length > truncateLen ) {
			ellipsisChars = ( ellipsisChars == null ) ? '..' : ellipsisChars;
			str = str.substring( 0, truncateLen - ellipsisChars.length ) + ellipsisChars;
		}
		return str;
	},


	/**
	 * Supports `Array.prototype.indexOf()` functionality for old IE (IE8 and below).
	 *
	 * @param {Array} arr The array to find an element of.
	 * @param {*} element The element to find in the array, and return the index of.
	 * @return {Number} The index of the `element`, or -1 if it was not found.
	 */
	indexOf : function( arr, element ) {
		if( Array.prototype.indexOf ) {
			return arr.indexOf( element );

		} else {
			for( var i = 0, len = arr.length; i < len; i++ ) {
				if( arr[ i ] === element ) return i;
			}
			return -1;
		}
	},


	/**
	 * Removes array elements based on a filtering function. Mutates the input
	 * array.
	 *
	 * Using this instead of the ES5 Array.prototype.filter() function, to allow
	 * Autolinker compatibility with IE8, and also to prevent creating many new
	 * arrays in memory for filtering.
	 *
	 * @param {Array} arr The array to remove elements from. This array is
	 *   mutated.
	 * @param {Function} fn A function which should return `true` to
	 *   remove an element.
	 * @return {Array} The mutated input `arr`.
	 */
	remove : function( arr, fn ) {
		for( var i = arr.length - 1; i >= 0; i-- ) {
			if( fn( arr[ i ] ) === true ) {
				arr.splice( i, 1 );
			}
		}
	},


	/**
	 * Performs the functionality of what modern browsers do when `String.prototype.split()` is called
	 * with a regular expression that contains capturing parenthesis.
	 *
	 * For example:
	 *
	 *     // Modern browsers:
	 *     "a,b,c".split( /(,)/ );  // --> [ 'a', ',', 'b', ',', 'c' ]
	 *
	 *     // Old IE (including IE8):
	 *     "a,b,c".split( /(,)/ );  // --> [ 'a', 'b', 'c' ]
	 *
	 * This method emulates the functionality of modern browsers for the old IE case.
	 *
	 * @param {String} str The string to split.
	 * @param {RegExp} splitRegex The regular expression to split the input `str` on. The splitting
	 *   character(s) will be spliced into the array, as in the "modern browsers" example in the
	 *   description of this method.
	 *   Note #1: the supplied regular expression **must** have the 'g' flag specified.
	 *   Note #2: for simplicity's sake, the regular expression does not need
	 *   to contain capturing parenthesis - it will be assumed that any match has them.
	 * @return {String[]} The split array of strings, with the splitting character(s) included.
	 */
	splitAndCapture : function( str, splitRegex ) {
		// @if DEBUG
		if( !splitRegex.global ) throw new Error( "`splitRegex` must have the 'g' flag set" );
		// @endif

		var result = [],
		    lastIdx = 0,
		    match;

		while( match = splitRegex.exec( str ) ) {
			result.push( str.substring( lastIdx, match.index ) );
			result.push( match[ 0 ] );  // push the splitting char(s)

			lastIdx = match.index + match[ 0 ].length;
		}
		result.push( str.substring( lastIdx ) );

		return result;
	},


	/**
	 * Trims the leading and trailing whitespace from a string.
	 *
	 * @param {String} str The string to trim.
	 * @return {String}
	 */
	trim : function( str ) {
		return str.replace( this.trimRegex, '' );
	}

};
/*global Autolinker */
/*jshint boss:true */
/**
 * @class Autolinker.HtmlTag
 * @extends Object
 *
 * Represents an HTML tag, which can be used to easily build/modify HTML tags programmatically.
 *
 * Autolinker uses this abstraction to create HTML tags, and then write them out as strings. You may also use
 * this class in your code, especially within a {@link Autolinker#replaceFn replaceFn}.
 *
 * ## Examples
 *
 * Example instantiation:
 *
 *     var tag = new Autolinker.HtmlTag( {
 *         tagName : 'a',
 *         attrs   : { 'href': 'http://google.com', 'class': 'external-link' },
 *         innerHtml : 'Google'
 *     } );
 *
 *     tag.toAnchorString();  // <a href="http://google.com" class="external-link">Google</a>
 *
 *     // Individual accessor methods
 *     tag.getTagName();                 // 'a'
 *     tag.getAttr( 'href' );            // 'http://google.com'
 *     tag.hasClass( 'external-link' );  // true
 *
 *
 * Using mutator methods (which may be used in combination with instantiation config properties):
 *
 *     var tag = new Autolinker.HtmlTag();
 *     tag.setTagName( 'a' );
 *     tag.setAttr( 'href', 'http://google.com' );
 *     tag.addClass( 'external-link' );
 *     tag.setInnerHtml( 'Google' );
 *
 *     tag.getTagName();                 // 'a'
 *     tag.getAttr( 'href' );            // 'http://google.com'
 *     tag.hasClass( 'external-link' );  // true
 *
 *     tag.toAnchorString();  // <a href="http://google.com" class="external-link">Google</a>
 *
 *
 * ## Example use within a {@link Autolinker#replaceFn replaceFn}
 *
 *     var html = Autolinker.link( "Test google.com", {
 *         replaceFn : function( autolinker, match ) {
 *             var tag = autolinker.getTagBuilder().build( match );  // returns an {@link Autolinker.HtmlTag} instance, configured with the Match's href and anchor text
 *             tag.setAttr( 'rel', 'nofollow' );
 *
 *             return tag;
 *         }
 *     } );
 *
 *     // generated html:
 *     //   Test <a href="http://google.com" target="_blank" rel="nofollow">google.com</a>
 *
 *
 * ## Example use with a new tag for the replacement
 *
 *     var html = Autolinker.link( "Test google.com", {
 *         replaceFn : function( autolinker, match ) {
 *             var tag = new Autolinker.HtmlTag( {
 *                 tagName : 'button',
 *                 attrs   : { 'title': 'Load URL: ' + match.getAnchorHref() },
 *                 innerHtml : 'Load URL: ' + match.getAnchorText()
 *             } );
 *
 *             return tag;
 *         }
 *     } );
 *
 *     // generated html:
 *     //   Test <button title="Load URL: http://google.com">Load URL: google.com</button>
 */
Autolinker.HtmlTag = Autolinker.Util.extend( Object, {

	/**
	 * @cfg {String} tagName
	 *
	 * The tag name. Ex: 'a', 'button', etc.
	 *
	 * Not required at instantiation time, but should be set using {@link #setTagName} before {@link #toAnchorString}
	 * is executed.
	 */

	/**
	 * @cfg {Object.<String, String>} attrs
	 *
	 * An key/value Object (map) of attributes to create the tag with. The keys are the attribute names, and the
	 * values are the attribute values.
	 */

	/**
	 * @cfg {String} innerHtml
	 *
	 * The inner HTML for the tag.
	 *
	 * Note the camel case name on `innerHtml`. Acronyms are camelCased in this utility (such as not to run into the acronym
	 * naming inconsistency that the DOM developers created with `XMLHttpRequest`). You may alternatively use {@link #innerHTML}
	 * if you prefer, but this one is recommended.
	 */

	/**
	 * @cfg {String} innerHTML
	 *
	 * Alias of {@link #innerHtml}, accepted for consistency with the browser DOM api, but prefer the camelCased version
	 * for acronym names.
	 */


	/**
	 * @protected
	 * @property {RegExp} whitespaceRegex
	 *
	 * Regular expression used to match whitespace in a string of CSS classes.
	 */
	whitespaceRegex : /\s+/,


	/**
	 * @constructor
	 * @param {Object} [cfg] The configuration properties for this class, in an Object (map)
	 */
	constructor : function( cfg ) {
		Autolinker.Util.assign( this, cfg );

		this.innerHtml = this.innerHtml || this.innerHTML;  // accept either the camelCased form or the fully capitalized acronym
	},


	/**
	 * Sets the tag name that will be used to generate the tag with.
	 *
	 * @param {String} tagName
	 * @return {Autolinker.HtmlTag} This HtmlTag instance, so that method calls may be chained.
	 */
	setTagName : function( tagName ) {
		this.tagName = tagName;
		return this;
	},


	/**
	 * Retrieves the tag name.
	 *
	 * @return {String}
	 */
	getTagName : function() {
		return this.tagName || "";
	},


	/**
	 * Sets an attribute on the HtmlTag.
	 *
	 * @param {String} attrName The attribute name to set.
	 * @param {String} attrValue The attribute value to set.
	 * @return {Autolinker.HtmlTag} This HtmlTag instance, so that method calls may be chained.
	 */
	setAttr : function( attrName, attrValue ) {
		var tagAttrs = this.getAttrs();
		tagAttrs[ attrName ] = attrValue;

		return this;
	},


	/**
	 * Retrieves an attribute from the HtmlTag. If the attribute does not exist, returns `undefined`.
	 *
	 * @param {String} attrName The attribute name to retrieve.
	 * @return {String} The attribute's value, or `undefined` if it does not exist on the HtmlTag.
	 */
	getAttr : function( attrName ) {
		return this.getAttrs()[ attrName ];
	},


	/**
	 * Sets one or more attributes on the HtmlTag.
	 *
	 * @param {Object.<String, String>} attrs A key/value Object (map) of the attributes to set.
	 * @return {Autolinker.HtmlTag} This HtmlTag instance, so that method calls may be chained.
	 */
	setAttrs : function( attrs ) {
		var tagAttrs = this.getAttrs();
		Autolinker.Util.assign( tagAttrs, attrs );

		return this;
	},


	/**
	 * Retrieves the attributes Object (map) for the HtmlTag.
	 *
	 * @return {Object.<String, String>} A key/value object of the attributes for the HtmlTag.
	 */
	getAttrs : function() {
		return this.attrs || ( this.attrs = {} );
	},


	/**
	 * Sets the provided `cssClass`, overwriting any current CSS classes on the HtmlTag.
	 *
	 * @param {String} cssClass One or more space-separated CSS classes to set (overwrite).
	 * @return {Autolinker.HtmlTag} This HtmlTag instance, so that method calls may be chained.
	 */
	setClass : function( cssClass ) {
		return this.setAttr( 'class', cssClass );
	},


	/**
	 * Convenience method to add one or more CSS classes to the HtmlTag. Will not add duplicate CSS classes.
	 *
	 * @param {String} cssClass One or more space-separated CSS classes to add.
	 * @return {Autolinker.HtmlTag} This HtmlTag instance, so that method calls may be chained.
	 */
	addClass : function( cssClass ) {
		var classAttr = this.getClass(),
		    whitespaceRegex = this.whitespaceRegex,
		    indexOf = Autolinker.Util.indexOf,  // to support IE8 and below
		    classes = ( !classAttr ) ? [] : classAttr.split( whitespaceRegex ),
		    newClasses = cssClass.split( whitespaceRegex ),
		    newClass;

		while( newClass = newClasses.shift() ) {
			if( indexOf( classes, newClass ) === -1 ) {
				classes.push( newClass );
			}
		}

		this.getAttrs()[ 'class' ] = classes.join( " " );
		return this;
	},


	/**
	 * Convenience method to remove one or more CSS classes from the HtmlTag.
	 *
	 * @param {String} cssClass One or more space-separated CSS classes to remove.
	 * @return {Autolinker.HtmlTag} This HtmlTag instance, so that method calls may be chained.
	 */
	removeClass : function( cssClass ) {
		var classAttr = this.getClass(),
		    whitespaceRegex = this.whitespaceRegex,
		    indexOf = Autolinker.Util.indexOf,  // to support IE8 and below
		    classes = ( !classAttr ) ? [] : classAttr.split( whitespaceRegex ),
		    removeClasses = cssClass.split( whitespaceRegex ),
		    removeClass;

		while( classes.length && ( removeClass = removeClasses.shift() ) ) {
			var idx = indexOf( classes, removeClass );
			if( idx !== -1 ) {
				classes.splice( idx, 1 );
			}
		}

		this.getAttrs()[ 'class' ] = classes.join( " " );
		return this;
	},


	/**
	 * Convenience method to retrieve the CSS class(es) for the HtmlTag, which will each be separated by spaces when
	 * there are multiple.
	 *
	 * @return {String}
	 */
	getClass : function() {
		return this.getAttrs()[ 'class' ] || "";
	},


	/**
	 * Convenience method to check if the tag has a CSS class or not.
	 *
	 * @param {String} cssClass The CSS class to check for.
	 * @return {Boolean} `true` if the HtmlTag has the CSS class, `false` otherwise.
	 */
	hasClass : function( cssClass ) {
		return ( ' ' + this.getClass() + ' ' ).indexOf( ' ' + cssClass + ' ' ) !== -1;
	},


	/**
	 * Sets the inner HTML for the tag.
	 *
	 * @param {String} html The inner HTML to set.
	 * @return {Autolinker.HtmlTag} This HtmlTag instance, so that method calls may be chained.
	 */
	setInnerHtml : function( html ) {
		this.innerHtml = html;

		return this;
	},


	/**
	 * Retrieves the inner HTML for the tag.
	 *
	 * @return {String}
	 */
	getInnerHtml : function() {
		return this.innerHtml || "";
	},


	/**
	 * Override of superclass method used to generate the HTML string for the tag.
	 *
	 * @return {String}
	 */
	toAnchorString : function() {
		var tagName = this.getTagName(),
		    attrsStr = this.buildAttrsStr();

		attrsStr = ( attrsStr ) ? ' ' + attrsStr : '';  // prepend a space if there are actually attributes

		return [ '<', tagName, attrsStr, '>', this.getInnerHtml(), '</', tagName, '>' ].join( "" );
	},


	/**
	 * Support method for {@link #toAnchorString}, returns the string space-separated key="value" pairs, used to populate
	 * the stringified HtmlTag.
	 *
	 * @protected
	 * @return {String} Example return: `attr1="value1" attr2="value2"`
	 */
	buildAttrsStr : function() {
		if( !this.attrs ) return "";  // no `attrs` Object (map) has been set, return empty string

		var attrs = this.getAttrs(),
		    attrsArr = [];

		for( var prop in attrs ) {
			if( attrs.hasOwnProperty( prop ) ) {
				attrsArr.push( prop + '="' + attrs[ prop ] + '"' );
			}
		}
		return attrsArr.join( " " );
	}

} );

/*global Autolinker */
/*
 * @class Autolinker.RegexLib
 * @singleton
 *
 * Builds and stores a library of the common regular expressions used by the
 * Autolinker utility.
 *
 * Other regular expressions may exist ad-hoc, but these are generally the
 * regular expressions that are shared between source files.
 */
Autolinker.RegexLib = (function() {

	/**
	 * The string form of a regular expression that would match all of the
	 * alphabetic ("letter") chars in the unicode character set when placed in a
	 * RegExp character class (`[]`). This includes all international alphabetic
	 * characters.
	 *
	 * These would be the characters matched by unicode regex engines `\p{L}`
	 * escape ("all letters").
	 *
	 * Taken from the XRegExp library: http://xregexp.com/
	 * Specifically: http://xregexp.com/v/3.0.0/unicode-categories.js
	 *
	 * @private
	 * @type {String}
	 */
	var alphaCharsStr = 'A-Za-z\xAA\xB5\xBA\xC0-\xD6\xD8-\xF6\xF8-\u02C1\u02C6-\u02D1\u02E0-\u02E4\u02EC\u02EE\u0370-\u0374\u0376\u0377\u037A-\u037D\u037F\u0386\u0388-\u038A\u038C\u038E-\u03A1\u03A3-\u03F5\u03F7-\u0481\u048A-\u052F\u0531-\u0556\u0559\u0561-\u0587\u05D0-\u05EA\u05F0-\u05F2\u0620-\u064A\u066E\u066F\u0671-\u06D3\u06D5\u06E5\u06E6\u06EE\u06EF\u06FA-\u06FC\u06FF\u0710\u0712-\u072F\u074D-\u07A5\u07B1\u07CA-\u07EA\u07F4\u07F5\u07FA\u0800-\u0815\u081A\u0824\u0828\u0840-\u0858\u08A0-\u08B4\u0904-\u0939\u093D\u0950\u0958-\u0961\u0971-\u0980\u0985-\u098C\u098F\u0990\u0993-\u09A8\u09AA-\u09B0\u09B2\u09B6-\u09B9\u09BD\u09CE\u09DC\u09DD\u09DF-\u09E1\u09F0\u09F1\u0A05-\u0A0A\u0A0F\u0A10\u0A13-\u0A28\u0A2A-\u0A30\u0A32\u0A33\u0A35\u0A36\u0A38\u0A39\u0A59-\u0A5C\u0A5E\u0A72-\u0A74\u0A85-\u0A8D\u0A8F-\u0A91\u0A93-\u0AA8\u0AAA-\u0AB0\u0AB2\u0AB3\u0AB5-\u0AB9\u0ABD\u0AD0\u0AE0\u0AE1\u0AF9\u0B05-\u0B0C\u0B0F\u0B10\u0B13-\u0B28\u0B2A-\u0B30\u0B32\u0B33\u0B35-\u0B39\u0B3D\u0B5C\u0B5D\u0B5F-\u0B61\u0B71\u0B83\u0B85-\u0B8A\u0B8E-\u0B90\u0B92-\u0B95\u0B99\u0B9A\u0B9C\u0B9E\u0B9F\u0BA3\u0BA4\u0BA8-\u0BAA\u0BAE-\u0BB9\u0BD0\u0C05-\u0C0C\u0C0E-\u0C10\u0C12-\u0C28\u0C2A-\u0C39\u0C3D\u0C58-\u0C5A\u0C60\u0C61\u0C85-\u0C8C\u0C8E-\u0C90\u0C92-\u0CA8\u0CAA-\u0CB3\u0CB5-\u0CB9\u0CBD\u0CDE\u0CE0\u0CE1\u0CF1\u0CF2\u0D05-\u0D0C\u0D0E-\u0D10\u0D12-\u0D3A\u0D3D\u0D4E\u0D5F-\u0D61\u0D7A-\u0D7F\u0D85-\u0D96\u0D9A-\u0DB1\u0DB3-\u0DBB\u0DBD\u0DC0-\u0DC6\u0E01-\u0E30\u0E32\u0E33\u0E40-\u0E46\u0E81\u0E82\u0E84\u0E87\u0E88\u0E8A\u0E8D\u0E94-\u0E97\u0E99-\u0E9F\u0EA1-\u0EA3\u0EA5\u0EA7\u0EAA\u0EAB\u0EAD-\u0EB0\u0EB2\u0EB3\u0EBD\u0EC0-\u0EC4\u0EC6\u0EDC-\u0EDF\u0F00\u0F40-\u0F47\u0F49-\u0F6C\u0F88-\u0F8C\u1000-\u102A\u103F\u1050-\u1055\u105A-\u105D\u1061\u1065\u1066\u106E-\u1070\u1075-\u1081\u108E\u10A0-\u10C5\u10C7\u10CD\u10D0-\u10FA\u10FC-\u1248\u124A-\u124D\u1250-\u1256\u1258\u125A-\u125D\u1260-\u1288\u128A-\u128D\u1290-\u12B0\u12B2-\u12B5\u12B8-\u12BE\u12C0\u12C2-\u12C5\u12C8-\u12D6\u12D8-\u1310\u1312-\u1315\u1318-\u135A\u1380-\u138F\u13A0-\u13F5\u13F8-\u13FD\u1401-\u166C\u166F-\u167F\u1681-\u169A\u16A0-\u16EA\u16F1-\u16F8\u1700-\u170C\u170E-\u1711\u1720-\u1731\u1740-\u1751\u1760-\u176C\u176E-\u1770\u1780-\u17B3\u17D7\u17DC\u1820-\u1877\u1880-\u18A8\u18AA\u18B0-\u18F5\u1900-\u191E\u1950-\u196D\u1970-\u1974\u1980-\u19AB\u19B0-\u19C9\u1A00-\u1A16\u1A20-\u1A54\u1AA7\u1B05-\u1B33\u1B45-\u1B4B\u1B83-\u1BA0\u1BAE\u1BAF\u1BBA-\u1BE5\u1C00-\u1C23\u1C4D-\u1C4F\u1C5A-\u1C7D\u1CE9-\u1CEC\u1CEE-\u1CF1\u1CF5\u1CF6\u1D00-\u1DBF\u1E00-\u1F15\u1F18-\u1F1D\u1F20-\u1F45\u1F48-\u1F4D\u1F50-\u1F57\u1F59\u1F5B\u1F5D\u1F5F-\u1F7D\u1F80-\u1FB4\u1FB6-\u1FBC\u1FBE\u1FC2-\u1FC4\u1FC6-\u1FCC\u1FD0-\u1FD3\u1FD6-\u1FDB\u1FE0-\u1FEC\u1FF2-\u1FF4\u1FF6-\u1FFC\u2071\u207F\u2090-\u209C\u2102\u2107\u210A-\u2113\u2115\u2119-\u211D\u2124\u2126\u2128\u212A-\u212D\u212F-\u2139\u213C-\u213F\u2145-\u2149\u214E\u2183\u2184\u2C00-\u2C2E\u2C30-\u2C5E\u2C60-\u2CE4\u2CEB-\u2CEE\u2CF2\u2CF3\u2D00-\u2D25\u2D27\u2D2D\u2D30-\u2D67\u2D6F\u2D80-\u2D96\u2DA0-\u2DA6\u2DA8-\u2DAE\u2DB0-\u2DB6\u2DB8-\u2DBE\u2DC0-\u2DC6\u2DC8-\u2DCE\u2DD0-\u2DD6\u2DD8-\u2DDE\u2E2F\u3005\u3006\u3031-\u3035\u303B\u303C\u3041-\u3096\u309D-\u309F\u30A1-\u30FA\u30FC-\u30FF\u3105-\u312D\u3131-\u318E\u31A0-\u31BA\u31F0-\u31FF\u3400-\u4DB5\u4E00-\u9FD5\uA000-\uA48C\uA4D0-\uA4FD\uA500-\uA60C\uA610-\uA61F\uA62A\uA62B\uA640-\uA66E\uA67F-\uA69D\uA6A0-\uA6E5\uA717-\uA71F\uA722-\uA788\uA78B-\uA7AD\uA7B0-\uA7B7\uA7F7-\uA801\uA803-\uA805\uA807-\uA80A\uA80C-\uA822\uA840-\uA873\uA882-\uA8B3\uA8F2-\uA8F7\uA8FB\uA8FD\uA90A-\uA925\uA930-\uA946\uA960-\uA97C\uA984-\uA9B2\uA9CF\uA9E0-\uA9E4\uA9E6-\uA9EF\uA9FA-\uA9FE\uAA00-\uAA28\uAA40-\uAA42\uAA44-\uAA4B\uAA60-\uAA76\uAA7A\uAA7E-\uAAAF\uAAB1\uAAB5\uAAB6\uAAB9-\uAABD\uAAC0\uAAC2\uAADB-\uAADD\uAAE0-\uAAEA\uAAF2-\uAAF4\uAB01-\uAB06\uAB09-\uAB0E\uAB11-\uAB16\uAB20-\uAB26\uAB28-\uAB2E\uAB30-\uAB5A\uAB5C-\uAB65\uAB70-\uABE2\uAC00-\uD7A3\uD7B0-\uD7C6\uD7CB-\uD7FB\uF900-\uFA6D\uFA70-\uFAD9\uFB00-\uFB06\uFB13-\uFB17\uFB1D\uFB1F-\uFB28\uFB2A-\uFB36\uFB38-\uFB3C\uFB3E\uFB40\uFB41\uFB43\uFB44\uFB46-\uFBB1\uFBD3-\uFD3D\uFD50-\uFD8F\uFD92-\uFDC7\uFDF0-\uFDFB\uFE70-\uFE74\uFE76-\uFEFC\uFF21-\uFF3A\uFF41-\uFF5A\uFF66-\uFFBE\uFFC2-\uFFC7\uFFCA-\uFFCF\uFFD2-\uFFD7\uFFDA-\uFFDC';

	/**
	 * The string form of a regular expression that would match all of the
	 * decimal number chars in the unicode character set when placed in a RegExp
	 * character class (`[]`).
	 *
	 * These would be the characters matched by unicode regex engines `\p{Nd}`
	 * escape ("all decimal numbers")
	 *
	 * Taken from the XRegExp library: http://xregexp.com/
	 * Specifically: http://xregexp.com/v/3.0.0/unicode-categories.js
	 *
	 * @private
	 * @type {String}
	 */
	var decimalNumbersStr = '0-9\u0660-\u0669\u06F0-\u06F9\u07C0-\u07C9\u0966-\u096F\u09E6-\u09EF\u0A66-\u0A6F\u0AE6-\u0AEF\u0B66-\u0B6F\u0BE6-\u0BEF\u0C66-\u0C6F\u0CE6-\u0CEF\u0D66-\u0D6F\u0DE6-\u0DEF\u0E50-\u0E59\u0ED0-\u0ED9\u0F20-\u0F29\u1040-\u1049\u1090-\u1099\u17E0-\u17E9\u1810-\u1819\u1946-\u194F\u19D0-\u19D9\u1A80-\u1A89\u1A90-\u1A99\u1B50-\u1B59\u1BB0-\u1BB9\u1C40-\u1C49\u1C50-\u1C59\uA620-\uA629\uA8D0-\uA8D9\uA900-\uA909\uA9D0-\uA9D9\uA9F0-\uA9F9\uAA50-\uAA59\uABF0-\uABF9\uFF10-\uFF19';


	// See documentation below
	var alphaNumericCharsStr = alphaCharsStr + decimalNumbersStr;


	// See documentation below
	var domainNameRegex = new RegExp( '[' + alphaNumericCharsStr + '.\\-]*[' + alphaNumericCharsStr + '\\-]' );


	// See documentation below
	var tldRegex = /(?:international|construction|contractors|enterprises|photography|productions|foundation|immobilien|industries|management|properties|technology|christmas|community|directory|education|equipment|institute|marketing|solutions|vacations|bargains|boutique|builders|catering|cleaning|clothing|computer|democrat|diamonds|graphics|holdings|lighting|partners|plumbing|supplies|training|ventures|academy|careers|company|cruises|domains|exposed|flights|florist|gallery|guitars|holiday|kitchen|neustar|okinawa|recipes|rentals|reviews|shiksha|singles|support|systems|agency|berlin|camera|center|coffee|condos|dating|estate|events|expert|futbol|kaufen|luxury|maison|monash|museum|nagoya|photos|repair|report|social|supply|tattoo|tienda|travel|viajes|villas|vision|voting|voyage|actor|build|cards|cheap|codes|dance|email|glass|house|mango|ninja|parts|photo|press|shoes|solar|today|tokyo|tools|watch|works|aero|arpa|asia|best|bike|blue|buzz|camp|club|cool|coop|farm|fish|gift|guru|info|jobs|kiwi|kred|land|limo|link|menu|mobi|moda|name|pics|pink|post|qpon|rich|ruhr|sexy|tips|vote|voto|wang|wien|wiki|zone|bar|bid|biz|cab|cat|ceo|com|edu|gov|int|kim|mil|net|onl|org|pro|pub|red|tel|uno|wed|xxx|xyz|ac|ad|ae|af|ag|ai|al|am|an|ao|aq|ar|as|at|au|aw|ax|az|ba|bb|bd|be|bf|bg|bh|bi|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|cr|cu|cv|cw|cx|cy|cz|de|dj|dk|dm|do|dz|ec|ee|eg|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gg|gh|gi|gl|gm|gn|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|im|in|io|iq|ir|is|it|je|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|mv|mw|mx|my|mz|na|nc|ne|nf|ng|ni|nl|no|np|nr|nu|nz|om|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|ps|pt|pw|py|qa|re|ro|rs|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sx|sy|sz|tc|td|tf|tg|th|tj|tk|tl|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|za|zm|zw)\b/;


	return {

		/**
		 * The string form of a regular expression that would match all of the
		 * letters and decimal number chars in the unicode character set when placed
		 * in a RegExp character class (`[]`).
		 *
		 * These would be the characters matched by unicode regex engines `[\p{L}\p{Nd}]`
		 * escape ("all letters and decimal numbers")
		 *
		 * @property {String} alphaNumericCharsStr
		 */
		alphaNumericCharsStr : alphaNumericCharsStr,

		/**
		 * A regular expression to match domain names of a URL or email address.
		 * Ex: 'google', 'yahoo', 'some-other-company', etc.
		 *
		 * @property {RegExp} domainNameRegex
		 */
		domainNameRegex : domainNameRegex,

		/**
		 * A regular expression to match top level domains (TLDs) for a URL or
		 * email address. Ex: 'com', 'org', 'net', etc.
		 *
		 * @property {RegExp} tldRegex
		 */
		tldRegex : tldRegex

	};


}() );
/*global Autolinker */
/*jshint sub:true */
/**
 * @protected
 * @class Autolinker.AnchorTagBuilder
 * @extends Object
 *
 * Builds anchor (&lt;a&gt;) tags for the Autolinker utility when a match is
 * found.
 *
 * Normally this class is instantiated, configured, and used internally by an
 * {@link Autolinker} instance, but may actually be retrieved in a {@link Autolinker#replaceFn replaceFn}
 * to create {@link Autolinker.HtmlTag HtmlTag} instances which may be modified
 * before returning from the {@link Autolinker#replaceFn replaceFn}. For
 * example:
 *
 *     var html = Autolinker.link( "Test google.com", {
 *         replaceFn : function( autolinker, match ) {
 *             var tag = autolinker.getTagBuilder().build( match );  // returns an {@link Autolinker.HtmlTag} instance
 *             tag.setAttr( 'rel', 'nofollow' );
 *
 *             return tag;
 *         }
 *     } );
 *
 *     // generated html:
 *     //   Test <a href="http://google.com" target="_blank" rel="nofollow">google.com</a>
 */
Autolinker.AnchorTagBuilder = Autolinker.Util.extend( Object, {

	/**
	 * @cfg {Boolean} newWindow
	 * @inheritdoc Autolinker#newWindow
	 */

	/**
	 * @cfg {Object} truncate
	 * @inheritdoc Autolinker#truncate
	 */

	/**
	 * @cfg {String} className
	 * @inheritdoc Autolinker#className
	 */


	/**
	 * @constructor
	 * @param {Object} [cfg] The configuration options for the AnchorTagBuilder instance, specified in an Object (map).
	 */
	constructor : function( cfg ) {
		Autolinker.Util.assign( this, cfg );
	},


	/**
	 * Generates the actual anchor (&lt;a&gt;) tag to use in place of the
	 * matched text, via its `match` object.
	 *
	 * @param {Autolinker.match.Match} match The Match instance to generate an
	 *   anchor tag from.
	 * @return {Autolinker.HtmlTag} The HtmlTag instance for the anchor tag.
	 */
	build : function( match ) {
		return new Autolinker.HtmlTag( {
			tagName   : 'a',
			attrs     : this.createAttrs( match.getType(), match.getAnchorHref() ),
			innerHtml : this.processAnchorText( match.getAnchorText() )
		} );
	},


	/**
	 * Creates the Object (map) of the HTML attributes for the anchor (&lt;a&gt;)
	 *   tag being generated.
	 *
	 * @protected
	 * @param {"url"/"email"/"phone"/"twitter"/"hashtag"} matchType The type of
	 *   match that an anchor tag is being generated for.
	 * @param {String} anchorHref The href for the anchor tag.
	 * @return {Object} A key/value Object (map) of the anchor tag's attributes.
	 */
	createAttrs : function( matchType, anchorHref ) {
		var attrs = {
			'href' : anchorHref  // we'll always have the `href` attribute
		};

		var cssClass = this.createCssClass( matchType );
		if( cssClass ) {
			attrs[ 'class' ] = cssClass;
		}
		if( this.newWindow ) {
			attrs[ 'target' ] = "_blank";
		}

		return attrs;
	},


	/**
	 * Creates the CSS class that will be used for a given anchor tag, based on
	 * the `matchType` and the {@link #className} config.
	 *
	 * @private
	 * @param {"url"/"email"/"phone"/"twitter"/"hashtag"} matchType The type of
	 *   match that an anchor tag is being generated for.
	 * @return {String} The CSS class string for the link. Example return:
	 *   "myLink myLink-url". If no {@link #className} was configured, returns
	 *   an empty string.
	 */
	createCssClass : function( matchType ) {
		var className = this.className;

		if( !className )
			return "";
		else
			return className + " " + className + "-" + matchType;  // ex: "myLink myLink-url", "myLink myLink-email", "myLink myLink-phone", "myLink myLink-twitter", or "myLink myLink-hashtag"
	},


	/**
	 * Processes the `anchorText` by truncating the text according to the
	 * {@link #truncate} config.
	 *
	 * @private
	 * @param {String} anchorText The anchor tag's text (i.e. what will be
	 *   displayed).
	 * @return {String} The processed `anchorText`.
	 */
	processAnchorText : function( anchorText ) {
		anchorText = this.doTruncate( anchorText );

		return anchorText;
	},


	/**
	 * Performs the truncation of the `anchorText` based on the {@link #truncate}
	 * option. If the `anchorText` is longer than the length specified by the
	 * {@link #truncate} option, the truncation is performed based on the
	 * `location` property. See {@link #truncate} for details.
	 *
	 * @private
	 * @param {String} anchorText The anchor tag's text (i.e. what will be
	 *   displayed).
	 * @return {String} The truncated anchor text.
	 */
	doTruncate : function( anchorText ) {
		var truncate = this.truncate;
		if( !truncate ) return anchorText;

		var truncateLength = truncate.length,
			truncateLocation = truncate.location;

		if( truncateLocation === 'smart' ) {
			return Autolinker.truncate.TruncateSmart( anchorText, truncateLength, '..' );

		} else if( truncateLocation === 'middle' ) {
			return Autolinker.truncate.TruncateMiddle( anchorText, truncateLength, '..' );

		} else {
			return Autolinker.truncate.TruncateEnd( anchorText, truncateLength, '..' );
		}
	}

} );

/*global Autolinker */
/**
 * @class Autolinker.htmlParser.HtmlParser
 * @extends Object
 *
 * An HTML parser implementation which simply walks an HTML string and returns an array of
 * {@link Autolinker.htmlParser.HtmlNode HtmlNodes} that represent the basic HTML structure of the input string.
 *
 * Autolinker uses this to only link URLs/emails/Twitter handles within text nodes, effectively ignoring / "walking
 * around" HTML tags.
 */
Autolinker.htmlParser.HtmlParser = Autolinker.Util.extend( Object, {

	/**
	 * @private
	 * @property {RegExp} htmlRegex
	 *
	 * The regular expression used to pull out HTML tags from a string. Handles namespaced HTML tags and
	 * attribute names, as specified by http://www.w3.org/TR/html-markup/syntax.html.
	 *
	 * Capturing groups:
	 *
	 * 1. The "!DOCTYPE" tag name, if a tag is a &lt;!DOCTYPE&gt; tag.
	 * 2. If it is an end tag, this group will have the '/'.
	 * 3. If it is a comment tag, this group will hold the comment text (i.e.
	 *    the text inside the `&lt;!--` and `--&gt;`.
	 * 4. The tag name for all tags (other than the &lt;!DOCTYPE&gt; tag)
	 */
	htmlRegex : (function() {
		var commentTagRegex = /!--([\s\S]+?)--/,
		    tagNameRegex = /[0-9a-zA-Z][0-9a-zA-Z:]*/,
		    attrNameRegex = /[^\s\0"'>\/=\x01-\x1F\x7F]+/,   // the unicode range accounts for excluding control chars, and the delete char
		    attrValueRegex = /(?:"[^"]*?"|'[^']*?'|[^'"=<>`\s]+)/, // double quoted, single quoted, or unquoted attribute values
		    nameEqualsValueRegex = attrNameRegex.source + '(?:\\s*=\\s*' + attrValueRegex.source + ')?';  // optional '=[value]'

		return new RegExp( [
			// for <!DOCTYPE> tag. Ex: <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">)
			'(?:',
				'<(!DOCTYPE)',  // *** Capturing Group 1 - If it's a doctype tag

					// Zero or more attributes following the tag name
					'(?:',
						'\\s+',  // one or more whitespace chars before an attribute

						// Either:
						// A. attr="value", or
						// B. "value" alone (To cover example doctype tag: <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">)
						'(?:', nameEqualsValueRegex, '|', attrValueRegex.source + ')',
					')*',
				'>',
			')',

			'|',

			// All other HTML tags (i.e. tags that are not <!DOCTYPE>)
			'(?:',
				'<(/)?',  // Beginning of a tag or comment. Either '<' for a start tag, or '</' for an end tag.
				          // *** Capturing Group 2: The slash or an empty string. Slash ('/') for end tag, empty string for start or self-closing tag.

					'(?:',
						commentTagRegex.source,  // *** Capturing Group 3 - A Comment Tag's Text

						'|',

						'(?:',

							// *** Capturing Group 4 - The tag name
							'(' + tagNameRegex.source + ')',

							// Zero or more attributes following the tag name
							'(?:',
								'\\s*',                // any number of whitespace chars before an attribute
								nameEqualsValueRegex,  // attr="value" (with optional ="value" part)
							')*',

							'\\s*/?',  // any trailing spaces and optional '/' before the closing '>'

						')',
					')',
				'>',
			')'
		].join( "" ), 'gi' );
	} )(),

	/**
	 * @private
	 * @property {RegExp} htmlCharacterEntitiesRegex
	 *
	 * The regular expression that matches common HTML character entities.
	 *
	 * Ignoring &amp; as it could be part of a query string -- handling it separately.
	 */
	htmlCharacterEntitiesRegex: /(&nbsp;|&#160;|&lt;|&#60;|&gt;|&#62;|&quot;|&#34;|&#39;)/gi,


	/**
	 * Parses an HTML string and returns a simple array of {@link Autolinker.htmlParser.HtmlNode HtmlNodes}
	 * to represent the HTML structure of the input string.
	 *
	 * @param {String} html The HTML to parse.
	 * @return {Autolinker.htmlParser.HtmlNode[]}
	 */
	parse : function( html ) {
		var htmlRegex = this.htmlRegex,
		    currentResult,
		    lastIndex = 0,
		    textAndEntityNodes,
		    nodes = [];  // will be the result of the method

		while( ( currentResult = htmlRegex.exec( html ) ) !== null ) {
			var tagText = currentResult[ 0 ],
			    commentText = currentResult[ 3 ], // if we've matched a comment
			    tagName = currentResult[ 1 ] || currentResult[ 4 ],  // The <!DOCTYPE> tag (ex: "!DOCTYPE"), or another tag (ex: "a" or "img")
			    isClosingTag = !!currentResult[ 2 ],
			    offset = currentResult.index,
			    inBetweenTagsText = html.substring( lastIndex, offset );

			// Push TextNodes and EntityNodes for any text found between tags
			if( inBetweenTagsText ) {
				textAndEntityNodes = this.parseTextAndEntityNodes( lastIndex, inBetweenTagsText );
				nodes.push.apply( nodes, textAndEntityNodes );
			}

			// Push the CommentNode or ElementNode
			if( commentText ) {
				nodes.push( this.createCommentNode( offset, tagText, commentText ) );
			} else {
				nodes.push( this.createElementNode( offset, tagText, tagName, isClosingTag ) );
			}

			lastIndex = offset + tagText.length;
		}

		// Process any remaining text after the last HTML element. Will process all of the text if there were no HTML elements.
		if( lastIndex < html.length ) {
			var text = html.substring( lastIndex );

			// Push TextNodes and EntityNodes for any text found between tags
			if( text ) {
				textAndEntityNodes = this.parseTextAndEntityNodes( lastIndex, text );
				nodes.push.apply( nodes, textAndEntityNodes );
			}
		}

		return nodes;
	},


	/**
	 * Parses text and HTML entity nodes from a given string. The input string
	 * should not have any HTML tags (elements) within it.
	 *
	 * @private
	 * @param {Number} offset The offset of the text node match within the
	 *   original HTML string.
	 * @param {String} text The string of text to parse. This is from an HTML
	 *   text node.
	 * @return {Autolinker.htmlParser.HtmlNode[]} An array of HtmlNodes to
	 *   represent the {@link Autolinker.htmlParser.TextNode TextNodes} and
	 *   {@link Autolinker.htmlParser.EntityNode EntityNodes} found.
	 */
	parseTextAndEntityNodes : function( offset, text ) {
		var nodes = [],
		    textAndEntityTokens = Autolinker.Util.splitAndCapture( text, this.htmlCharacterEntitiesRegex );  // split at HTML entities, but include the HTML entities in the results array

		// Every even numbered token is a TextNode, and every odd numbered token is an EntityNode
		// For example: an input `text` of "Test &quot;this&quot; today" would turn into the
		//   `textAndEntityTokens`: [ 'Test ', '&quot;', 'this', '&quot;', ' today' ]
		for( var i = 0, len = textAndEntityTokens.length; i < len; i += 2 ) {
			var textToken = textAndEntityTokens[ i ],
			    entityToken = textAndEntityTokens[ i + 1 ];

			if( textToken ) {
				nodes.push( this.createTextNode( offset, textToken ) );
				offset += textToken.length;
			}
			if( entityToken ) {
				nodes.push( this.createEntityNode( offset, entityToken ) );
				offset += entityToken.length;
			}
		}
		return nodes;
	},


	/**
	 * Factory method to create an {@link Autolinker.htmlParser.CommentNode CommentNode}.
	 *
	 * @private
	 * @param {Number} offset The offset of the match within the original HTML
	 *   string.
	 * @param {String} tagText The full text of the tag (comment) that was
	 *   matched, including its &lt;!-- and --&gt;.
	 * @param {String} commentText The full text of the comment that was matched.
	 */
	createCommentNode : function( offset, tagText, commentText ) {
		return new Autolinker.htmlParser.CommentNode( {
			offset : offset,
			text   : tagText,
			comment: Autolinker.Util.trim( commentText )
		} );
	},


	/**
	 * Factory method to create an {@link Autolinker.htmlParser.ElementNode ElementNode}.
	 *
	 * @private
	 * @param {Number} offset The offset of the match within the original HTML
	 *   string.
	 * @param {String} tagText The full text of the tag (element) that was
	 *   matched, including its attributes.
	 * @param {String} tagName The name of the tag. Ex: An &lt;img&gt; tag would
	 *   be passed to this method as "img".
	 * @param {Boolean} isClosingTag `true` if it's a closing tag, false
	 *   otherwise.
	 * @return {Autolinker.htmlParser.ElementNode}
	 */
	createElementNode : function( offset, tagText, tagName, isClosingTag ) {
		return new Autolinker.htmlParser.ElementNode( {
			offset  : offset,
			text    : tagText,
			tagName : tagName.toLowerCase(),
			closing : isClosingTag
		} );
	},


	/**
	 * Factory method to create a {@link Autolinker.htmlParser.EntityNode EntityNode}.
	 *
	 * @private
	 * @param {Number} offset The offset of the match within the original HTML
	 *   string.
	 * @param {String} text The text that was matched for the HTML entity (such
	 *   as '&amp;nbsp;').
	 * @return {Autolinker.htmlParser.EntityNode}
	 */
	createEntityNode : function( offset, text ) {
		return new Autolinker.htmlParser.EntityNode( { offset: offset, text: text } );
	},


	/**
	 * Factory method to create a {@link Autolinker.htmlParser.TextNode TextNode}.
	 *
	 * @private
	 * @param {Number} offset The offset of the match within the original HTML
	 *   string.
	 * @param {String} text The text that was matched.
	 * @return {Autolinker.htmlParser.TextNode}
	 */
	createTextNode : function( offset, text ) {
		return new Autolinker.htmlParser.TextNode( { offset: offset, text: text } );
	}

} );
/*global Autolinker */
/**
 * @abstract
 * @class Autolinker.htmlParser.HtmlNode
 *
 * Represents an HTML node found in an input string. An HTML node is one of the
 * following:
 *
 * 1. An {@link Autolinker.htmlParser.ElementNode ElementNode}, which represents
 *    HTML tags.
 * 2. A {@link Autolinker.htmlParser.CommentNode CommentNode}, which represents
 *    HTML comments.
 * 3. A {@link Autolinker.htmlParser.TextNode TextNode}, which represents text
 *    outside or within HTML tags.
 * 4. A {@link Autolinker.htmlParser.EntityNode EntityNode}, which represents
 *    one of the known HTML entities that Autolinker looks for. This includes
 *    common ones such as &amp;quot; and &amp;nbsp;
 */
Autolinker.htmlParser.HtmlNode = Autolinker.Util.extend( Object, {

	/**
	 * @cfg {Number} offset (required)
	 *
	 * The offset of the HTML node in the original text that was parsed.
	 */
	offset : undefined,

	/**
	 * @cfg {String} text (required)
	 *
	 * The text that was matched for the HtmlNode.
	 *
	 * - In the case of an {@link Autolinker.htmlParser.ElementNode ElementNode},
	 *   this will be the tag's text.
	 * - In the case of an {@link Autolinker.htmlParser.CommentNode CommentNode},
	 *   this will be the comment's text.
	 * - In the case of a {@link Autolinker.htmlParser.TextNode TextNode}, this
	 *   will be the text itself.
	 * - In the case of a {@link Autolinker.htmlParser.EntityNode EntityNode},
	 *   this will be the text of the HTML entity.
	 */
	text : undefined,


	/**
	 * @constructor
	 * @param {Object} cfg The configuration properties for the Match instance,
	 * specified in an Object (map).
	 */
	constructor : function( cfg ) {
		Autolinker.Util.assign( this, cfg );

		// @if DEBUG
		if( this.offset == null ) throw new Error( '`offset` cfg required' );
		if( this.text == null ) throw new Error( '`text` cfg required' );
		// @endif
	},


	/**
	 * Returns a string name for the type of node that this class represents.
	 *
	 * @abstract
	 * @return {String}
	 */
	getType : Autolinker.Util.abstractMethod,


	/**
	 * Retrieves the {@link #offset} of the HtmlNode. This is the offset of the
	 * HTML node in the original string that was parsed.
	 *
	 * @return {Number}
	 */
	getOffset : function() {
		return this.offset;
	},


	/**
	 * Retrieves the {@link #text} for the HtmlNode.
	 *
	 * @return {String}
	 */
	getText : function() {
		return this.text;
	}

} );
/*global Autolinker */
/**
 * @class Autolinker.htmlParser.CommentNode
 * @extends Autolinker.htmlParser.HtmlNode
 *
 * Represents an HTML comment node that has been parsed by the
 * {@link Autolinker.htmlParser.HtmlParser}.
 *
 * See this class's superclass ({@link Autolinker.htmlParser.HtmlNode}) for more
 * details.
 */
Autolinker.htmlParser.CommentNode = Autolinker.Util.extend( Autolinker.htmlParser.HtmlNode, {

	/**
	 * @cfg {String} comment (required)
	 *
	 * The text inside the comment tag. This text is stripped of any leading or
	 * trailing whitespace.
	 */
	comment : '',


	/**
	 * Returns a string name for the type of node that this class represents.
	 *
	 * @return {String}
	 */
	getType : function() {
		return 'comment';
	},


	/**
	 * Returns the comment inside the comment tag.
	 *
	 * @return {String}
	 */
	getComment : function() {
		return this.comment;
	}

} );
/*global Autolinker */
/**
 * @class Autolinker.htmlParser.ElementNode
 * @extends Autolinker.htmlParser.HtmlNode
 *
 * Represents an HTML element node that has been parsed by the {@link Autolinker.htmlParser.HtmlParser}.
 *
 * See this class's superclass ({@link Autolinker.htmlParser.HtmlNode}) for more
 * details.
 */
Autolinker.htmlParser.ElementNode = Autolinker.Util.extend( Autolinker.htmlParser.HtmlNode, {

	/**
	 * @cfg {String} tagName (required)
	 *
	 * The name of the tag that was matched.
	 */
	tagName : '',

	/**
	 * @cfg {Boolean} closing (required)
	 *
	 * `true` if the element (tag) is a closing tag, `false` if its an opening
	 * tag.
	 */
	closing : false,


	/**
	 * Returns a string name for the type of node that this class represents.
	 *
	 * @return {String}
	 */
	getType : function() {
		return 'element';
	},


	/**
	 * Returns the HTML element's (tag's) name. Ex: for an &lt;img&gt; tag,
	 * returns "img".
	 *
	 * @return {String}
	 */
	getTagName : function() {
		return this.tagName;
	},


	/**
	 * Determines if the HTML element (tag) is a closing tag. Ex: &lt;div&gt;
	 * returns `false`, while &lt;/div&gt; returns `true`.
	 *
	 * @return {Boolean}
	 */
	isClosing : function() {
		return this.closing;
	}

} );
/*global Autolinker */
/**
 * @class Autolinker.htmlParser.EntityNode
 * @extends Autolinker.htmlParser.HtmlNode
 *
 * Represents a known HTML entity node that has been parsed by the {@link Autolinker.htmlParser.HtmlParser}.
 * Ex: '&amp;nbsp;', or '&amp#160;' (which will be retrievable from the {@link #getText}
 * method.
 *
 * Note that this class will only be returned from the HtmlParser for the set of
 * checked HTML entity nodes  defined by the {@link Autolinker.htmlParser.HtmlParser#htmlCharacterEntitiesRegex}.
 *
 * See this class's superclass ({@link Autolinker.htmlParser.HtmlNode}) for more
 * details.
 */
Autolinker.htmlParser.EntityNode = Autolinker.Util.extend( Autolinker.htmlParser.HtmlNode, {

	/**
	 * Returns a string name for the type of node that this class represents.
	 *
	 * @return {String}
	 */
	getType : function() {
		return 'entity';
	}

} );
/*global Autolinker */
/**
 * @class Autolinker.htmlParser.TextNode
 * @extends Autolinker.htmlParser.HtmlNode
 *
 * Represents a text node that has been parsed by the {@link Autolinker.htmlParser.HtmlParser}.
 *
 * See this class's superclass ({@link Autolinker.htmlParser.HtmlNode}) for more
 * details.
 */
Autolinker.htmlParser.TextNode = Autolinker.Util.extend( Autolinker.htmlParser.HtmlNode, {

	/**
	 * Returns a string name for the type of node that this class represents.
	 *
	 * @return {String}
	 */
	getType : function() {
		return 'text';
	}

} );
/*global Autolinker */
/**
 * @abstract
 * @class Autolinker.match.Match
 *
 * Represents a match found in an input string which should be Autolinked. A Match object is what is provided in a
 * {@link Autolinker#replaceFn replaceFn}, and may be used to query for details about the match.
 *
 * For example:
 *
 *     var input = "...";  // string with URLs, Email Addresses, and Twitter Handles
 *
 *     var linkedText = Autolinker.link( input, {
 *         replaceFn : function( autolinker, match ) {
 *             console.log( "href = ", match.getAnchorHref() );
 *             console.log( "text = ", match.getAnchorText() );
 *
 *             switch( match.getType() ) {
 *                 case 'url' :
 *                     console.log( "url: ", match.getUrl() );
 *
 *                 case 'email' :
 *                     console.log( "email: ", match.getEmail() );
 *
 *                 case 'twitter' :
 *                     console.log( "twitter: ", match.getTwitterHandle() );
 *             }
 *         }
 *     } );
 *
 * See the {@link Autolinker} class for more details on using the {@link Autolinker#replaceFn replaceFn}.
 */
Autolinker.match.Match = Autolinker.Util.extend( Object, {

	/**
	 * @cfg {Autolinker.AnchorTagBuilder} tagBuilder (required)
	 *
	 * Reference to the AnchorTagBuilder instance to use to generate an anchor
	 * tag for the Match.
	 */

	/**
	 * @cfg {String} matchedText (required)
	 *
	 * The original text that was matched by the {@link Autolinker.matcher.Matcher}.
	 */

	/**
	 * @cfg {Number} offset (required)
	 *
	 * The offset of where the match was made in the input string.
	 */


	/**
	 * @constructor
	 * @param {Object} cfg The configuration properties for the Match
	 *   instance, specified in an Object (map).
	 */
	constructor : function( cfg ) {
		// @if DEBUG
		if( cfg.tagBuilder == null ) throw new Error( '`tagBuilder` cfg required' );
		if( cfg.matchedText == null ) throw new Error( '`matchedText` cfg required' );
		if( cfg.offset == null ) throw new Error( '`offset` cfg required' );
		// @endif

		this.tagBuilder = cfg.tagBuilder;
		this.matchedText = cfg.matchedText;
		this.offset = cfg.offset;
	},


	/**
	 * Returns a string name for the type of match that this class represents.
	 *
	 * @abstract
	 * @return {String}
	 */
	getType : Autolinker.Util.abstractMethod,


	/**
	 * Returns the original text that was matched.
	 *
	 * @return {String}
	 */
	getMatchedText : function() {
		return this.matchedText;
	},


	/**
	 * Sets the {@link #offset} of where the match was made in the input string.
	 *
	 * A {@link Autolinker.matcher.Matcher} will be fed only HTML text nodes,
	 * and will therefore set an original offset that is relative to the HTML
	 * text node itself. However, we want this offset to be relative to the full
	 * HTML input string, and thus if using {@link Autolinker#parse} (rather
	 * than calling a {@link Autolinker.matcher.Matcher} directly), then this
	 * offset is corrected after the Matcher itself has done its job.
	 *
	 * @param {Number} offset
	 */
	setOffset : function( offset ) {
		this.offset = offset;
	},


	/**
	 * Returns the offset of where the match was made in the input string. This
	 * is the 0-based index of the match.
	 *
	 * @return {Number}
	 */
	getOffset : function() {
		return this.offset;
	},


	/**
	 * Returns the anchor href that should be generated for the match.
	 *
	 * @abstract
	 * @return {String}
	 */
	getAnchorHref : Autolinker.Util.abstractMethod,


	/**
	 * Returns the anchor text that should be generated for the match.
	 *
	 * @abstract
	 * @return {String}
	 */
	getAnchorText : Autolinker.Util.abstractMethod,


	/**
	 * Builds and returns an {@link Autolinker.HtmlTag} instance based on the
	 * Match.
	 *
	 * This can be used to easily generate anchor tags from matches, and either
	 * return their HTML string, or modify them before doing so.
	 *
	 * Example Usage:
	 *
	 *     var tag = match.buildTag();
	 *     tag.addClass( 'cordova-link' );
	 *     tag.setAttr( 'target', '_system' );
	 *
	 *     tag.toAnchorString();  // <a href="http://google.com" class="cordova-link" target="_system">Google</a>
	 */
	buildTag : function() {
		return this.tagBuilder.build( this );
	}

} );
/*global Autolinker */
/**
 * @class Autolinker.match.Email
 * @extends Autolinker.match.Match
 *
 * Represents a Email match found in an input string which should be Autolinked.
 *
 * See this class's superclass ({@link Autolinker.match.Match}) for more details.
 */
Autolinker.match.Email = Autolinker.Util.extend( Autolinker.match.Match, {

	/**
	 * @cfg {String} email (required)
	 *
	 * The email address that was matched.
	 */


	/**
	 * @constructor
	 * @param {Object} cfg The configuration properties for the Match
	 *   instance, specified in an Object (map).
	 */
	constructor : function( cfg ) {
		Autolinker.match.Match.prototype.constructor.call( this, cfg );

		// @if DEBUG
		if( !cfg.email ) throw new Error( '`email` cfg required' );
		// @endif

		this.email = cfg.email;
	},


	/**
	 * Returns a string name for the type of match that this class represents.
	 *
	 * @return {String}
	 */
	getType : function() {
		return 'email';
	},


	/**
	 * Returns the email address that was matched.
	 *
	 * @return {String}
	 */
	getEmail : function() {
		return this.email;
	},


	/**
	 * Returns the anchor href that should be generated for the match.
	 *
	 * @return {String}
	 */
	getAnchorHref : function() {
		return 'mailto:' + this.email;
	},


	/**
	 * Returns the anchor text that should be generated for the match.
	 *
	 * @return {String}
	 */
	getAnchorText : function() {
		return this.email;
	}

} );
/*global Autolinker */
/**
 * @class Autolinker.match.Hashtag
 * @extends Autolinker.match.Match
 *
 * Represents a Hashtag match found in an input string which should be
 * Autolinked.
 *
 * See this class's superclass ({@link Autolinker.match.Match}) for more
 * details.
 */
Autolinker.match.Hashtag = Autolinker.Util.extend( Autolinker.match.Match, {

	/**
	 * @cfg {String} serviceName
	 *
	 * The service to point hashtag matches to. See {@link Autolinker#hashtag}
	 * for available values.
	 */

	/**
	 * @cfg {String} hashtag (required)
	 *
	 * The Hashtag that was matched, without the '#'.
	 */


	/**
	 * @constructor
	 * @param {Object} cfg The configuration properties for the Match
	 *   instance, specified in an Object (map).
	 */
	constructor : function( cfg ) {
		Autolinker.match.Match.prototype.constructor.call( this, cfg );

		// @if DEBUG
		// TODO: if( !serviceName ) throw new Error( '`serviceName` cfg required' );
		if( !cfg.hashtag ) throw new Error( '`hashtag` cfg required' );
		// @endif

		this.serviceName = cfg.serviceName;
		this.hashtag = cfg.hashtag;
	},


	/**
	 * Returns the type of match that this class represents.
	 *
	 * @return {String}
	 */
	getType : function() {
		return 'hashtag';
	},


	/**
	 * Returns the configured {@link #serviceName} to point the Hashtag to.
	 * Ex: 'facebook', 'twitter'.
	 *
	 * @return {String}
	 */
	getServiceName : function() {
		return this.serviceName;
	},


	/**
	 * Returns the matched hashtag, without the '#' character.
	 *
	 * @return {String}
	 */
	getHashtag : function() {
		return this.hashtag;
	},


	/**
	 * Returns the anchor href that should be generated for the match.
	 *
	 * @return {String}
	 */
	getAnchorHref : function() {
		var serviceName = this.serviceName,
		    hashtag = this.hashtag;

		switch( serviceName ) {
			case 'twitter' :
				return 'https://twitter.com/hashtag/' + hashtag;
			case 'facebook' :
				return 'https://www.facebook.com/hashtag/' + hashtag;
			case 'instagram' :
				return 'https://instagram.com/explore/tags/' + hashtag;

			default :  // Shouldn't happen because Autolinker's constructor should block any invalid values, but just in case.
				throw new Error( 'Unknown service name to point hashtag to: ', serviceName );
		}
	},


	/**
	 * Returns the anchor text that should be generated for the match.
	 *
	 * @return {String}
	 */
	getAnchorText : function() {
		return '#' + this.hashtag;
	}

} );

/*global Autolinker */
/**
 * @class Autolinker.match.Phone
 * @extends Autolinker.match.Match
 *
 * Represents a Phone number match found in an input string which should be
 * Autolinked.
 *
 * See this class's superclass ({@link Autolinker.match.Match}) for more
 * details.
 */
Autolinker.match.Phone = Autolinker.Util.extend( Autolinker.match.Match, {

	/**
	 * @protected
	 * @property {String} number (required)
	 *
	 * The phone number that was matched, without any delimiter characters.
	 *
	 * Note: This is a string to allow for prefixed 0's.
	 */

	/**
	 * @protected
	 * @property  {Boolean} plusSign (required)
	 *
	 * `true` if the matched phone number started with a '+' sign. We'll include
	 * it in the `tel:` URL if so, as this is needed for international numbers.
	 *
	 * Ex: '+1 (123) 456 7879'
	 */


	/**
	 * @constructor
	 * @param {Object} cfg The configuration properties for the Match
	 *   instance, specified in an Object (map).
	 */
	constructor : function( cfg ) {
		Autolinker.match.Match.prototype.constructor.call( this, cfg );

		// @if DEBUG
		if( !cfg.number ) throw new Error( '`number` cfg required' );
		if( cfg.plusSign == null ) throw new Error( '`plusSign` cfg required' );
		// @endif

		this.number = cfg.number;
		this.plusSign = cfg.plusSign;
	},


	/**
	 * Returns a string name for the type of match that this class represents.
	 *
	 * @return {String}
	 */
	getType : function() {
		return 'phone';
	},


	/**
	 * Returns the phone number that was matched as a string, without any
	 * delimiter characters.
	 *
	 * Note: This is a string to allow for prefixed 0's.
	 *
	 * @return {String}
	 */
	getNumber: function() {
		return this.number;
	},


	/**
	 * Returns the anchor href that should be generated for the match.
	 *
	 * @return {String}
	 */
	getAnchorHref : function() {
		return 'tel:' + ( this.plusSign ? '+' : '' ) + this.number;
	},


	/**
	 * Returns the anchor text that should be generated for the match.
	 *
	 * @return {String}
	 */
	getAnchorText : function() {
		return this.matchedText;
	}

} );

/*global Autolinker */
/**
 * @class Autolinker.match.Twitter
 * @extends Autolinker.match.Match
 *
 * Represents a Twitter match found in an input string which should be Autolinked.
 *
 * See this class's superclass ({@link Autolinker.match.Match}) for more details.
 */
Autolinker.match.Twitter = Autolinker.Util.extend( Autolinker.match.Match, {

	/**
	 * @cfg {String} twitterHandle (required)
	 *
	 * The Twitter handle that was matched, without the '@' character.
	 */


	/**
	 * @constructor
	 * @param {Object} cfg The configuration properties for the Match
	 *   instance, specified in an Object (map).
	 */
	constructor : function( cfg) {
		Autolinker.match.Match.prototype.constructor.call( this, cfg );

		// @if DEBUG
		if( !cfg.twitterHandle ) throw new Error( '`twitterHandle` cfg required' );
		// @endif

		this.twitterHandle = cfg.twitterHandle;
	},


	/**
	 * Returns the type of match that this class represents.
	 *
	 * @return {String}
	 */
	getType : function() {
		return 'twitter';
	},


	/**
	 * Returns the twitter handle, without the '@' character.
	 *
	 * @return {String}
	 */
	getTwitterHandle : function() {
		return this.twitterHandle;
	},


	/**
	 * Returns the anchor href that should be generated for the match.
	 *
	 * @return {String}
	 */
	getAnchorHref : function() {
		return 'https://twitter.com/' + this.twitterHandle;
	},


	/**
	 * Returns the anchor text that should be generated for the match.
	 *
	 * @return {String}
	 */
	getAnchorText : function() {
		return '@' + this.twitterHandle;
	}

} );
/*global Autolinker */
/**
 * @class Autolinker.match.Url
 * @extends Autolinker.match.Match
 *
 * Represents a Url match found in an input string which should be Autolinked.
 *
 * See this class's superclass ({@link Autolinker.match.Match}) for more details.
 */
Autolinker.match.Url = Autolinker.Util.extend( Autolinker.match.Match, {

	/**
	 * @cfg {String} url (required)
	 *
	 * The url that was matched.
	 */

	/**
	 * @cfg {"scheme"/"www"/"tld"} urlMatchType (required)
	 *
	 * The type of URL match that this class represents. This helps to determine
	 * if the match was made in the original text with a prefixed scheme (ex:
	 * 'http://www.google.com'), a prefixed 'www' (ex: 'www.google.com'), or
	 * was matched by a known top-level domain (ex: 'google.com').
	 */

	/**
	 * @cfg {Boolean} protocolUrlMatch (required)
	 *
	 * `true` if the URL is a match which already has a protocol (i.e.
	 * 'http://'), `false` if the match was from a 'www' or known TLD match.
	 */

	/**
	 * @cfg {Boolean} protocolRelativeMatch (required)
	 *
	 * `true` if the URL is a protocol-relative match. A protocol-relative match
	 * is a URL that starts with '//', and will be either http:// or https://
	 * based on the protocol that the site is loaded under.
	 */

	/**
	 * @cfg {Boolean} stripPrefix (required)
	 * @inheritdoc Autolinker#cfg-stripPrefix
	 */


	/**
	 * @constructor
	 * @param {Object} cfg The configuration properties for the Match
	 *   instance, specified in an Object (map).
	 */
	constructor : function( cfg ) {
		Autolinker.match.Match.prototype.constructor.call( this, cfg );

		// @if DEBUG
		if( cfg.urlMatchType !== 'scheme' && cfg.urlMatchType !== 'www' && cfg.urlMatchType !== 'tld' ) throw new Error( '`urlMatchType` cfg must be one of: "scheme", "www", or "tld"' );
		if( !cfg.url ) throw new Error( '`url` cfg required' );
		if( cfg.protocolUrlMatch == null ) throw new Error( '`protocolUrlMatch` cfg required' );
		if( cfg.protocolRelativeMatch == null ) throw new Error( '`protocolRelativeMatch` cfg required' );
		if( cfg.stripPrefix == null ) throw new Error( '`stripPrefix` cfg required' );
		// @endif

		this.urlMatchType = cfg.urlMatchType;
		this.url = cfg.url;
		this.protocolUrlMatch = cfg.protocolUrlMatch;
		this.protocolRelativeMatch = cfg.protocolRelativeMatch;
		this.stripPrefix = cfg.stripPrefix;
	},


	/**
	 * @private
	 * @property {RegExp} urlPrefixRegex
	 *
	 * A regular expression used to remove the 'http://' or 'https://' and/or the 'www.' from URLs.
	 */
	urlPrefixRegex: /^(https?:\/\/)?(www\.)?/i,

	/**
	 * @private
	 * @property {RegExp} protocolRelativeRegex
	 *
	 * The regular expression used to remove the protocol-relative '//' from the {@link #url} string, for purposes
	 * of {@link #getAnchorText}. A protocol-relative URL is, for example, "//yahoo.com"
	 */
	protocolRelativeRegex : /^\/\//,

	/**
	 * @private
	 * @property {Boolean} protocolPrepended
	 *
	 * Will be set to `true` if the 'http://' protocol has been prepended to the {@link #url} (because the
	 * {@link #url} did not have a protocol)
	 */
	protocolPrepended : false,


	/**
	 * Returns a string name for the type of match that this class represents.
	 *
	 * @return {String}
	 */
	getType : function() {
		return 'url';
	},


	/**
	 * Returns a string name for the type of URL match that this class
	 * represents.
	 *
	 * This helps to determine if the match was made in the original text with a
	 * prefixed scheme (ex: 'http://www.google.com'), a prefixed 'www' (ex:
	 * 'www.google.com'), or was matched by a known top-level domain (ex:
	 * 'google.com').
	 *
	 * @return {"scheme"/"www"/"tld"}
	 */
	getUrlMatchType : function() {
		return this.urlMatchType;
	},


	/**
	 * Returns the url that was matched, assuming the protocol to be 'http://' if the original
	 * match was missing a protocol.
	 *
	 * @return {String}
	 */
	getUrl : function() {
		var url = this.url;

		// if the url string doesn't begin with a protocol, assume 'http://'
		if( !this.protocolRelativeMatch && !this.protocolUrlMatch && !this.protocolPrepended ) {
			url = this.url = 'http://' + url;

			this.protocolPrepended = true;
		}

		return url;
	},


	/**
	 * Returns the anchor href that should be generated for the match.
	 *
	 * @return {String}
	 */
	getAnchorHref : function() {
		var url = this.getUrl();

		return url.replace( /&amp;/g, '&' );  // any &amp;'s in the URL should be converted back to '&' if they were displayed as &amp; in the source html
	},


	/**
	 * Returns the anchor text that should be generated for the match.
	 *
	 * @return {String}
	 */
	getAnchorText : function() {
		var anchorText = this.getMatchedText();

		if( this.protocolRelativeMatch ) {
			// Strip off any protocol-relative '//' from the anchor text
			anchorText = this.stripProtocolRelativePrefix( anchorText );
		}
		if( this.stripPrefix ) {
			anchorText = this.stripUrlPrefix( anchorText );
		}
		anchorText = this.removeTrailingSlash( anchorText );  // remove trailing slash, if there is one

		return anchorText;
	},


	// ---------------------------------------

	// Utility Functionality

	/**
	 * Strips the URL prefix (such as "http://" or "https://") from the given text.
	 *
	 * @private
	 * @param {String} text The text of the anchor that is being generated, for which to strip off the
	 *   url prefix (such as stripping off "http://")
	 * @return {String} The `anchorText`, with the prefix stripped.
	 */
	stripUrlPrefix : function( text ) {
		return text.replace( this.urlPrefixRegex, '' );
	},


	/**
	 * Strips any protocol-relative '//' from the anchor text.
	 *
	 * @private
	 * @param {String} text The text of the anchor that is being generated, for which to strip off the
	 *   protocol-relative prefix (such as stripping off "//")
	 * @return {String} The `anchorText`, with the protocol-relative prefix stripped.
	 */
	stripProtocolRelativePrefix : function( text ) {
		return text.replace( this.protocolRelativeRegex, '' );
	},


	/**
	 * Removes any trailing slash from the given `anchorText`, in preparation for the text to be displayed.
	 *
	 * @private
	 * @param {String} anchorText The text of the anchor that is being generated, for which to remove any trailing
	 *   slash ('/') that may exist.
	 * @return {String} The `anchorText`, with the trailing slash removed.
	 */
	removeTrailingSlash : function( anchorText ) {
		if( anchorText.charAt( anchorText.length - 1 ) === '/' ) {
			anchorText = anchorText.slice( 0, -1 );
		}
		return anchorText;
	}

} );
/*global Autolinker */
/**
 * @abstract
 * @class Autolinker.matcher.Matcher
 *
 * An abstract class and interface for individual matchers to find matches in
 * an input string with linkified versions of them.
 *
 * Note that Matchers do not take HTML into account - they must be fed the text
 * nodes of any HTML string, which is handled by {@link Autolinker#parse}.
 */
Autolinker.matcher.Matcher = Autolinker.Util.extend( Object, {

	/**
	 * @cfg {Autolinker.AnchorTagBuilder} tagBuilder (required)
	 *
	 * Reference to the AnchorTagBuilder instance to use to generate HTML tags
	 * for {@link Autolinker.match.Match Matches}.
	 */


	/**
	 * @constructor
	 * @param {Object} cfg The configuration properties for the Matcher
	 *   instance, specified in an Object (map).
	 */
	constructor : function( cfg ) {
		// @if DEBUG
		if( !cfg.tagBuilder ) throw new Error( '`tagBuilder` cfg required' );
		// @endif

		this.tagBuilder = cfg.tagBuilder;
	},


	/**
	 * Parses the input `text` and returns the array of {@link Autolinker.match.Match Matches}
	 * for the matcher.
	 *
	 * @abstract
	 * @param {String} text The text to scan and replace matches in.
	 * @return {Autolinker.match.Match[]}
	 */
	parseMatches : Autolinker.Util.abstractMethod

} );
/*global Autolinker */
/**
 * @class Autolinker.matcher.Email
 * @extends Autolinker.matcher.Matcher
 *
 * Matcher to find email matches in an input string.
 *
 * See this class's superclass ({@link Autolinker.matcher.Matcher}) for more details.
 */
Autolinker.matcher.Email = Autolinker.Util.extend( Autolinker.matcher.Matcher, {

	/**
	 * The regular expression to match email addresses. Example match:
	 *
	 *     person@place.com
	 *
	 * @private
	 * @property {RegExp} matcherRegex
	 */
	matcherRegex : (function() {
		var alphaNumericChars = Autolinker.RegexLib.alphaNumericCharsStr,
		    emailRegex = new RegExp( '[' + alphaNumericChars + '\\-;:&=+$.,]+@' ),  // something@ for email addresses (a.k.a. local-part)
			domainNameRegex = Autolinker.RegexLib.domainNameRegex,
			tldRegex = Autolinker.RegexLib.tldRegex;  // match our known top level domains (TLDs)

		return new RegExp( [
			emailRegex.source,
			domainNameRegex.source,
			'\\.', tldRegex.source   // '.com', '.net', etc
		].join( "" ), 'gi' );
	} )(),


	/**
	 * @inheritdoc
	 */
	parseMatches : function( text ) {
		var matcherRegex = this.matcherRegex,
		    tagBuilder = this.tagBuilder,
		    matches = [],
		    match;

		while( ( match = matcherRegex.exec( text ) ) !== null ) {
			var matchedText = match[ 0 ];

			matches.push( new Autolinker.match.Email( {
				tagBuilder  : tagBuilder,
				matchedText : matchedText,
				offset      : match.index,
				email       : matchedText
			} ) );
		}

		return matches;
	}

} );
/*global Autolinker */
/**
 * @class Autolinker.matcher.Hashtag
 * @extends Autolinker.matcher.Matcher
 *
 * Matcher to find Hashtag matches in an input string.
 */
Autolinker.matcher.Hashtag = Autolinker.Util.extend( Autolinker.matcher.Matcher, {

	/**
	 * @cfg {String} serviceName
	 *
	 * The service to point hashtag matches to. See {@link Autolinker#hashtag}
	 * for available values.
	 */


	/**
	 * The regular expression to match Hashtags. Example match:
	 *
	 *     #asdf
	 *
	 * @private
	 * @property {RegExp} matcherRegex
	 */
	matcherRegex : new RegExp( '#[_' + Autolinker.RegexLib.alphaNumericCharsStr + ']{1,139}', 'g' ),

	/**
	 * The regular expression to use to check the character before a username match to
	 * make sure we didn't accidentally match an email address.
	 *
	 * For example, the string "asdf@asdf.com" should not match "@asdf" as a username.
	 *
	 * @private
	 * @property {RegExp} nonWordCharRegex
	 */
	nonWordCharRegex : new RegExp( '[^' + Autolinker.RegexLib.alphaNumericCharsStr + ']' ),


	/**
	 * @constructor
	 * @param {Object} cfg The configuration properties for the Match instance,
	 *   specified in an Object (map).
	 */
	constructor : function( cfg ) {
		Autolinker.matcher.Matcher.prototype.constructor.call( this, cfg );

		this.serviceName = cfg.serviceName;
	},


	/**
	 * @inheritdoc
	 */
	parseMatches : function( text ) {
		var matcherRegex = this.matcherRegex,
		    nonWordCharRegex = this.nonWordCharRegex,
		    serviceName = this.serviceName,
		    tagBuilder = this.tagBuilder,
		    matches = [],
		    match;

		while( ( match = matcherRegex.exec( text ) ) !== null ) {
			var offset = match.index,
			    prevChar = text.charAt( offset - 1 );

			// If we found the match at the beginning of the string, or we found the match
			// and there is a whitespace char in front of it (meaning it is not a '#' char
			// in the middle of a word), then it is a hashtag match.
			if( offset === 0 || nonWordCharRegex.test( prevChar ) ) {
				var matchedText = match[ 0 ],
				    hashtag = match[ 0 ].slice( 1 );  // strip off the '#' character at the beginning

				matches.push( new Autolinker.match.Hashtag( {
					tagBuilder  : tagBuilder,
					matchedText : matchedText,
					offset      : offset,
					serviceName : serviceName,
					hashtag     : hashtag
				} ) );
			}
		}

		return matches;
	}

} );
/*global Autolinker */
/**
 * @class Autolinker.matcher.Phone
 * @extends Autolinker.matcher.Matcher
 *
 * Matcher to find Phone number matches in an input string.
 *
 * See this class's superclass ({@link Autolinker.matcher.Matcher}) for more
 * details.
 */
Autolinker.matcher.Phone = Autolinker.Util.extend( Autolinker.matcher.Matcher, {

	/**
	 * The regular expression to match Phone numbers. Example match:
	 *
	 *     (123) 456-7890
	 *
	 * This regular expression has the following capturing groups:
	 *
	 * 1. The prefixed '+' sign, if there is one.
	 *
	 * @private
	 * @property {RegExp} matcherRegex
	 */
	matcherRegex : /(?:(\+)?\d{1,3}[-\040.])?\(?\d{3}\)?[-\040.]?\d{3}[-\040.]\d{4}/g,  // ex: (123) 456-7890, 123 456 7890, 123-456-7890, etc.

	/**
	 * @inheritdoc
	 */
	parseMatches : function( text ) {
		var matcherRegex = this.matcherRegex,
		    tagBuilder = this.tagBuilder,
		    matches = [],
		    match;

		while( ( match = matcherRegex.exec( text ) ) !== null ) {
			// Remove non-numeric values from phone number string
			var matchedText = match[ 0 ],
			    cleanNumber = matchedText.replace( /\D/g, '' ),  // strip out non-digit characters
			    plusSign = !!match[ 1 ];  // match[ 1 ] is the prefixed plus sign, if there is one

			matches.push( new Autolinker.match.Phone( {
				tagBuilder  : tagBuilder,
				matchedText : matchedText,
				offset      : match.index,
				number      : cleanNumber,
				plusSign    : plusSign
			} ) );
		}

		return matches;
	}

} );
/*global Autolinker */
/**
 * @class Autolinker.matcher.Twitter
 * @extends Autolinker.matcher.Matcher
 *
 * Matcher to find/replace username matches in an input string.
 */
Autolinker.matcher.Twitter = Autolinker.Util.extend( Autolinker.matcher.Matcher, {

	/**
	 * The regular expression to match username handles. Example match:
	 *
	 *     @asdf
	 *
	 * @private
	 * @property {RegExp} matcherRegex
	 */
	matcherRegex : new RegExp( '@[_' + Autolinker.RegexLib.alphaNumericCharsStr + ']{1,20}', 'g' ),

	/**
	 * The regular expression to use to check the character before a username match to
	 * make sure we didn't accidentally match an email address.
	 *
	 * For example, the string "asdf@asdf.com" should not match "@asdf" as a username.
	 *
	 * @private
	 * @property {RegExp} nonWordCharRegex
	 */
	nonWordCharRegex : new RegExp( '[^' + Autolinker.RegexLib.alphaNumericCharsStr + ']' ),


	/**
	 * @inheritdoc
	 */
	parseMatches : function( text ) {
		var matcherRegex = this.matcherRegex,
		    nonWordCharRegex = this.nonWordCharRegex,
		    tagBuilder = this.tagBuilder,
		    matches = [],
		    match;

		while( ( match = matcherRegex.exec( text ) ) !== null ) {
			var offset = match.index,
			    prevChar = text.charAt( offset - 1 );

			// If we found the match at the beginning of the string, or we found the match
			// and there is a whitespace char in front of it (meaning it is not an email
			// address), then it is a username match.
			if( offset === 0 || nonWordCharRegex.test( prevChar ) ) {
				var matchedText = match[ 0 ],
				    twitterHandle = match[ 0 ].slice( 1 );  // strip off the '@' character at the beginning

				matches.push( new Autolinker.match.Twitter( {
					tagBuilder    : tagBuilder,
					matchedText   : matchedText,
					offset        : offset,
					twitterHandle : twitterHandle
				} ) );
			}
		}

		return matches;
	}

} );
/*global Autolinker */
/**
 * @class Autolinker.matcher.Url
 * @extends Autolinker.matcher.Matcher
 *
 * Matcher to find URL matches in an input string.
 *
 * See this class's superclass ({@link Autolinker.matcher.Matcher}) for more details.
 */
Autolinker.matcher.Url = Autolinker.Util.extend( Autolinker.matcher.Matcher, {

	/**
	 * @cfg {Boolean} stripPrefix (required)
	 * @inheritdoc Autolinker#stripPrefix
	 */


	/**
	 * @private
	 * @property {RegExp} matcherRegex
	 *
	 * The regular expression to match URLs with an optional scheme, port
	 * number, path, query string, and hash anchor.
	 *
	 * Example matches:
	 *
	 *     http://google.com
	 *     www.google.com
	 *     google.com/path/to/file?q1=1&q2=2#myAnchor
	 *
	 *
	 * This regular expression will have the following capturing groups:
	 *
	 * 1.  Group that matches a scheme-prefixed URL (i.e. 'http://google.com').
	 *     This is used to match scheme URLs with just a single word, such as
	 *     'http://localhost', where we won't double check that the domain name
	 *     has at least one dot ('.') in it.
	 * 2.  Group that matches a 'www.' prefixed URL. This is only matched if the
	 *     'www.' text was not prefixed by a scheme (i.e.: not prefixed by
	 *     'http://', 'ftp:', etc.)
	 * 3.  A protocol-relative ('//') match for the case of a 'www.' prefixed
	 *     URL. Will be an empty string if it is not a protocol-relative match.
	 *     We need to know the character before the '//' in order to determine
	 *     if it is a valid match or the // was in a string we don't want to
	 *     auto-link.
	 * 4.  Group that matches a known TLD (top level domain), when a scheme
	 *     or 'www.'-prefixed domain is not matched.
	 * 5.  A protocol-relative ('//') match for the case of a known TLD prefixed
	 *     URL. Will be an empty string if it is not a protocol-relative match.
	 *     See #3 for more info.
	 */
	matcherRegex : (function() {
		var schemeRegex = /(?:[A-Za-z][-.+A-Za-z0-9]*:(?![A-Za-z][-.+A-Za-z0-9]*:\/\/)(?!\d+\/?)(?:\/\/)?)/,  // match protocol, allow in format "http://" or "mailto:". However, do not match the first part of something like 'link:http://www.google.com' (i.e. don't match "link:"). Also, make sure we don't interpret 'google.com:8000' as if 'google.com' was a protocol here (i.e. ignore a trailing port number in this regex)
		    wwwRegex = /(?:www\.)/,                  // starting with 'www.'
		    domainNameRegex = Autolinker.RegexLib.domainNameRegex,
		    tldRegex = Autolinker.RegexLib.tldRegex,  // match our known top level domains (TLDs)
		    alphaNumericCharsStr = Autolinker.RegexLib.alphaNumericCharsStr,

		    // Allow optional path, query string, and hash anchor, not ending in the following characters: "?!:,.;"
		    // http://blog.codinghorror.com/the-problem-with-urls/
		    urlSuffixRegex = new RegExp( '[' + alphaNumericCharsStr + '\\-+&@#/%=~_()|\'$*\\[\\]?!:,.;]*[' + alphaNumericCharsStr + '\\-+&@#/%=~_()|\'$*\\[\\]]' );

		return new RegExp( [
			'(?:', // parens to cover match for scheme (optional), and domain
				'(',  // *** Capturing group $1, for a scheme-prefixed url (ex: http://google.com)
					schemeRegex.source,
					domainNameRegex.source,
				')',

				'|',

				'(',  // *** Capturing group $2, for a 'www.' prefixed url (ex: www.google.com)
					'(//)?',  // *** Capturing group $3 for an optional protocol-relative URL. Must be at the beginning of the string or start with a non-word character (handled later)
					wwwRegex.source,
					domainNameRegex.source,
				')',

				'|',

				'(',  // *** Capturing group $4, for known a TLD url (ex: google.com)
					'(//)?',  // *** Capturing group $5 for an optional protocol-relative URL. Must be at the beginning of the string or start with a non-word character (handled later)
					domainNameRegex.source + '\\.',
					tldRegex.source,
				')',
			')',

			'(?:' + urlSuffixRegex.source + ')?'  // match for path, query string, and/or hash anchor - optional
		].join( "" ), 'gi' );
	} )(),


	/**
	 * A regular expression to use to check the character before a protocol-relative
	 * URL match. We don't want to match a protocol-relative URL if it is part
	 * of another word.
	 *
	 * For example, we want to match something like "Go to: //google.com",
	 * but we don't want to match something like "abc//google.com"
	 *
	 * This regular expression is used to test the character before the '//'.
	 *
	 * @private
	 * @type {RegExp} wordCharRegExp
	 */
	wordCharRegExp : /\w/,


	/**
	 * The regular expression to match opening parenthesis in a URL match.
	 *
	 * This is to determine if we have unbalanced parenthesis in the URL, and to
	 * drop the final parenthesis that was matched if so.
	 *
	 * Ex: The text "(check out: wikipedia.com/something_(disambiguation))"
	 * should only autolink the inner "wikipedia.com/something_(disambiguation)"
	 * part, so if we find that we have unbalanced parenthesis, we will drop the
	 * last one for the match.
	 *
	 * @private
	 * @property {RegExp}
	 */
	openParensRe : /\(/g,

	/**
	 * The regular expression to match closing parenthesis in a URL match. See
	 * {@link #openParensRe} for more information.
	 *
	 * @private
	 * @property {RegExp}
	 */
	closeParensRe : /\)/g,


	/**
	 * @constructor
	 * @param {Object} cfg The configuration properties for the Match instance,
	 *   specified in an Object (map).
	 */
	constructor : function( cfg ) {
		Autolinker.matcher.Matcher.prototype.constructor.call( this, cfg );

		this.stripPrefix = cfg.stripPrefix;

		// @if DEBUG
		if( this.stripPrefix == null ) throw new Error( '`stripPrefix` cfg required' );
		// @endif
	},


	/**
	 * @inheritdoc
	 */
	parseMatches : function( text ) {
		var matcherRegex = this.matcherRegex,
		    stripPrefix = this.stripPrefix,
		    tagBuilder = this.tagBuilder,
		    matches = [],
		    match;

		while( ( match = matcherRegex.exec( text ) ) !== null ) {
			var matchStr = match[ 0 ],
			    schemeUrlMatch = match[ 1 ],
			    wwwUrlMatch = match[ 2 ],
			    wwwProtocolRelativeMatch = match[ 3 ],
			    //tldUrlMatch = match[ 4 ],  -- not needed at the moment
			    tldProtocolRelativeMatch = match[ 5 ],
			    offset = match.index,
			    protocolRelativeMatch = wwwProtocolRelativeMatch || tldProtocolRelativeMatch,
				prevChar = text.charAt( offset - 1 );

			if( !Autolinker.matcher.UrlMatchValidator.isValid( matchStr, schemeUrlMatch ) ) {
				continue;
			}

			// If the match is preceded by an '@' character, then it is either
			// an email address or a username. Skip these types of matches.
			if( offset > 0 && prevChar === '@' ) {
				continue;
			}

			// If it's a protocol-relative '//' match, but the character before the '//'
			// was a word character (i.e. a letter/number), then we found the '//' in the
			// middle of another word (such as "asdf//asdf.com"). In this case, skip the
			// match.
			if( offset > 0 && protocolRelativeMatch && this.wordCharRegExp.test( prevChar ) ) {
				continue;
			}

			// Handle a closing parenthesis at the end of the match, and exclude
			// it if there is not a matching open parenthesis in the match
			// itself.
			if( this.matchHasUnbalancedClosingParen( matchStr ) ) {
				matchStr = matchStr.substr( 0, matchStr.length - 1 );  // remove the trailing ")"
			} else {
				// Handle an invalid character after the TLD
				var pos = this.matchHasInvalidCharAfterTld( matchStr, schemeUrlMatch );
				if( pos > -1 ) {
					matchStr = matchStr.substr( 0, pos ); // remove the trailing invalid chars
				}
			}

			var urlMatchType = schemeUrlMatch ? 'scheme' : ( wwwUrlMatch ? 'www' : 'tld' ),
			    protocolUrlMatch = !!schemeUrlMatch;

			matches.push( new Autolinker.match.Url( {
				tagBuilder            : tagBuilder,
				matchedText           : matchStr,
				offset                : offset,
				urlMatchType          : urlMatchType,
				url                   : matchStr,
				protocolUrlMatch      : protocolUrlMatch,
				protocolRelativeMatch : !!protocolRelativeMatch,
				stripPrefix           : stripPrefix
			} ) );
		}

		return matches;
	},


	/**
	 * Determines if a match found has an unmatched closing parenthesis. If so,
	 * this parenthesis will be removed from the match itself, and appended
	 * after the generated anchor tag.
	 *
	 * A match may have an extra closing parenthesis at the end of the match
	 * because the regular expression must include parenthesis for URLs such as
	 * "wikipedia.com/something_(disambiguation)", which should be auto-linked.
	 *
	 * However, an extra parenthesis *will* be included when the URL itself is
	 * wrapped in parenthesis, such as in the case of "(wikipedia.com/something_(disambiguation))".
	 * In this case, the last closing parenthesis should *not* be part of the
	 * URL itself, and this method will return `true`.
	 *
	 * @private
	 * @param {String} matchStr The full match string from the {@link #matcherRegex}.
	 * @return {Boolean} `true` if there is an unbalanced closing parenthesis at
	 *   the end of the `matchStr`, `false` otherwise.
	 */
	matchHasUnbalancedClosingParen : function( matchStr ) {
		var lastChar = matchStr.charAt( matchStr.length - 1 );

		if( lastChar === ')' ) {
			var openParensMatch = matchStr.match( this.openParensRe ),
			    closeParensMatch = matchStr.match( this.closeParensRe ),
			    numOpenParens = ( openParensMatch && openParensMatch.length ) || 0,
			    numCloseParens = ( closeParensMatch && closeParensMatch.length ) || 0;

			if( numOpenParens < numCloseParens ) {
				return true;
			}
		}

		return false;
	},


	/**
	 * Determine if there's an invalid character after the TLD in a URL. Valid
	 * characters after TLD are ':/?#'. Exclude scheme matched URLs from this
	 * check.
	 *
	 * @private
	 * @param {String} urlMatch The matched URL, if there was one. Will be an
	 *   empty string if the match is not a URL match.
	 * @param {String} schemeUrlMatch The match URL string for a scheme
	 *   match. Ex: 'http://yahoo.com'. This is used to match something like
	 *   'http://localhost', where we won't double check that the domain name
	 *   has at least one '.' in it.
	 * @return {Number} the position where the invalid character was found. If
	 *   no such character was found, returns -1
	 */
	matchHasInvalidCharAfterTld : function( urlMatch, schemeUrlMatch ) {
		if( !urlMatch ) {
			return -1;
		}

		var offset = 0;
		if ( schemeUrlMatch ) {
			offset = urlMatch.indexOf(':');
			urlMatch = urlMatch.slice(offset);
		}

		var re = /^((.?\/\/)?[A-Za-z0-9\u00C0-\u017F\.\-]*[A-Za-z0-9\u00C0-\u017F\-]\.[A-Za-z]+)/;
		var res = re.exec( urlMatch );
		if ( res === null ) {
			return -1;
		}

		offset += res[1].length;
		urlMatch = urlMatch.slice(res[1].length);
		if (/^[^.A-Za-z:\/?#]/.test(urlMatch)) {
			return offset;
		}

		return -1;
	}

} );
/*global Autolinker */
/*jshint scripturl:true */
/**
 * @private
 * @class Autolinker.matcher.UrlMatchValidator
 * @singleton
 *
 * Used by Autolinker to filter out false URL positives from the
 * {@link Autolinker.matcher.Url UrlMatcher}.
 *
 * Due to the limitations of regular expressions (including the missing feature
 * of look-behinds in JS regular expressions), we cannot always determine the
 * validity of a given match. This class applies a bit of additional logic to
 * filter out any false positives that have been matched by the
 * {@link Autolinker.matcher.Url UrlMatcher}.
 */
Autolinker.matcher.UrlMatchValidator = {

	/**
	 * Regex to test for a full protocol, with the two trailing slashes. Ex: 'http://'
	 *
	 * @private
	 * @property {RegExp} hasFullProtocolRegex
	 */
	hasFullProtocolRegex : /^[A-Za-z][-.+A-Za-z0-9]*:\/\//,

	/**
	 * Regex to find the URI scheme, such as 'mailto:'.
	 *
	 * This is used to filter out 'javascript:' and 'vbscript:' schemes.
	 *
	 * @private
	 * @property {RegExp} uriSchemeRegex
	 */
	uriSchemeRegex : /^[A-Za-z][-.+A-Za-z0-9]*:/,

	/**
	 * Regex to determine if at least one word char exists after the protocol (i.e. after the ':')
	 *
	 * @private
	 * @property {RegExp} hasWordCharAfterProtocolRegex
	 */
	hasWordCharAfterProtocolRegex : /:[^\s]*?[A-Za-z\u00C0-\u017F]/,


	/**
	 * Determines if a given URL match found by the {@link Autolinker.matcher.Url UrlMatcher}
	 * is valid. Will return `false` for:
	 *
	 * 1) URL matches which do not have at least have one period ('.') in the
	 *    domain name (effectively skipping over matches like "abc:def").
	 *    However, URL matches with a protocol will be allowed (ex: 'http://localhost')
	 * 2) URL matches which do not have at least one word character in the
	 *    domain name (effectively skipping over matches like "git:1.0").
	 * 3) A protocol-relative url match (a URL beginning with '//') whose
	 *    previous character is a word character (effectively skipping over
	 *    strings like "abc//google.com")
	 *
	 * Otherwise, returns `true`.
	 *
	 * @param {String} urlMatch The matched URL, if there was one. Will be an
	 *   empty string if the match is not a URL match.
	 * @param {String} protocolUrlMatch The match URL string for a protocol
	 *   match. Ex: 'http://yahoo.com'. This is used to match something like
	 *   'http://localhost', where we won't double check that the domain name
	 *   has at least one '.' in it.
	 * @return {Boolean} `true` if the match given is valid and should be
	 *   processed, or `false` if the match is invalid and/or should just not be
	 *   processed.
	 */
	isValid : function( urlMatch, protocolUrlMatch ) {
		if(
			( protocolUrlMatch && !this.isValidUriScheme( protocolUrlMatch ) ) ||
			this.urlMatchDoesNotHaveProtocolOrDot( urlMatch, protocolUrlMatch ) ||    // At least one period ('.') must exist in the URL match for us to consider it an actual URL, *unless* it was a full protocol match (like 'http://localhost')
			this.urlMatchDoesNotHaveAtLeastOneWordChar( urlMatch, protocolUrlMatch )  // At least one letter character must exist in the domain name after a protocol match. Ex: skip over something like "git:1.0"
		) {
			return false;
		}

		return true;
	},


	/**
	 * Determines if the URI scheme is a valid scheme to be autolinked. Returns
	 * `false` if the scheme is 'javascript:' or 'vbscript:'
	 *
	 * @private
	 * @param {String} uriSchemeMatch The match URL string for a full URI scheme
	 *   match. Ex: 'http://yahoo.com' or 'mailto:a@a.com'.
	 * @return {Boolean} `true` if the scheme is a valid one, `false` otherwise.
	 */
	isValidUriScheme : function( uriSchemeMatch ) {
		var uriScheme = uriSchemeMatch.match( this.uriSchemeRegex )[ 0 ].toLowerCase();

		return ( uriScheme !== 'javascript:' && uriScheme !== 'vbscript:' );
	},


	/**
	 * Determines if a URL match does not have either:
	 *
	 * a) a full protocol (i.e. 'http://'), or
	 * b) at least one dot ('.') in the domain name (for a non-full-protocol
	 *    match).
	 *
	 * Either situation is considered an invalid URL (ex: 'git:d' does not have
	 * either the '://' part, or at least one dot in the domain name. If the
	 * match was 'git:abc.com', we would consider this valid.)
	 *
	 * @private
	 * @param {String} urlMatch The matched URL, if there was one. Will be an
	 *   empty string if the match is not a URL match.
	 * @param {String} protocolUrlMatch The match URL string for a protocol
	 *   match. Ex: 'http://yahoo.com'. This is used to match something like
	 *   'http://localhost', where we won't double check that the domain name
	 *   has at least one '.' in it.
	 * @return {Boolean} `true` if the URL match does not have a full protocol,
	 *   or at least one dot ('.') in a non-full-protocol match.
	 */
	urlMatchDoesNotHaveProtocolOrDot : function( urlMatch, protocolUrlMatch ) {
		return ( !!urlMatch && ( !protocolUrlMatch || !this.hasFullProtocolRegex.test( protocolUrlMatch ) ) && urlMatch.indexOf( '.' ) === -1 );
	},


	/**
	 * Determines if a URL match does not have at least one word character after
	 * the protocol (i.e. in the domain name).
	 *
	 * At least one letter character must exist in the domain name after a
	 * protocol match. Ex: skip over something like "git:1.0"
	 *
	 * @private
	 * @param {String} urlMatch The matched URL, if there was one. Will be an
	 *   empty string if the match is not a URL match.
	 * @param {String} protocolUrlMatch The match URL string for a protocol
	 *   match. Ex: 'http://yahoo.com'. This is used to know whether or not we
	 *   have a protocol in the URL string, in order to check for a word
	 *   character after the protocol separator (':').
	 * @return {Boolean} `true` if the URL match does not have at least one word
	 *   character in it after the protocol, `false` otherwise.
	 */
	urlMatchDoesNotHaveAtLeastOneWordChar : function( urlMatch, protocolUrlMatch ) {
		if( urlMatch && protocolUrlMatch ) {
			return !this.hasWordCharAfterProtocolRegex.test( urlMatch );
		} else {
			return false;
		}
	}

};
/*global Autolinker */
/**
 * A truncation feature where the ellipsis will be placed at the end of the URL.
 *
 * @param {String} anchorText
 * @param {Number} truncateLen The maximum length of the truncated output URL string.
 * @param {String} ellipsisChars The characters to place within the url, e.g. "..".
 * @return {String} The truncated URL.
 */
Autolinker.truncate.TruncateEnd = function(anchorText, truncateLen, ellipsisChars){
	return Autolinker.Util.ellipsis( anchorText, truncateLen, ellipsisChars );
};

/*global Autolinker */
/**
 * Date: 2015-10-05
 * Author: Kasper Søfren <soefritz@gmail.com> (https://github.com/kafoso)
 *
 * A truncation feature, where the ellipsis will be placed in the dead-center of the URL.
 *
 * @param {String} url             A URL.
 * @param {Number} truncateLen     The maximum length of the truncated output URL string.
 * @param {String} ellipsisChars   The characters to place within the url, e.g. "..".
 * @return {String} The truncated URL.
 */
Autolinker.truncate.TruncateMiddle = function(url, truncateLen, ellipsisChars){
  if (url.length <= truncateLen) {
    return url;
  }
  var availableLength = truncateLen - ellipsisChars.length;
  var end = "";
  if (availableLength > 0) {
    end = url.substr((-1)*Math.floor(availableLength/2));
  }
  return (url.substr(0, Math.ceil(availableLength/2)) + ellipsisChars + end).substr(0, truncateLen);
};

/*global Autolinker */
/**
 * Date: 2015-10-05
 * Author: Kasper Søfren <soefritz@gmail.com> (https://github.com/kafoso)
 *
 * A truncation feature, where the ellipsis will be placed at a section within
 * the URL making it still somewhat human readable.
 *
 * @param {String} url						 A URL.
 * @param {Number} truncateLen		 The maximum length of the truncated output URL string.
 * @param {String} ellipsisChars	 The characters to place within the url, e.g. "..".
 * @return {String} The truncated URL.
 */
Autolinker.truncate.TruncateSmart = function(url, truncateLen, ellipsisChars){
	var parse_url = function(url){ // Functionality inspired by PHP function of same name
		var urlObj = {};
		var urlSub = url;
		var match = urlSub.match(/^([a-z]+):\/\//i);
		if (match) {
			urlObj.scheme = match[1];
			urlSub = urlSub.substr(match[0].length);
		}
		match = urlSub.match(/^(.*?)(?=(\?|#|\/|$))/i);
		if (match) {
			urlObj.host = match[1];
			urlSub = urlSub.substr(match[0].length);
		}
		match = urlSub.match(/^\/(.*?)(?=(\?|#|$))/i);
		if (match) {
			urlObj.path = match[1];
			urlSub = urlSub.substr(match[0].length);
		}
		match = urlSub.match(/^\?(.*?)(?=(#|$))/i);
		if (match) {
			urlObj.query = match[1];
			urlSub = urlSub.substr(match[0].length);
		}
		match = urlSub.match(/^#(.*?)$/i);
		if (match) {
			urlObj.fragment = match[1];
			//urlSub = urlSub.substr(match[0].length);  -- not used. Uncomment if adding another block.
		}
		return urlObj;
	};

	var buildUrl = function(urlObj){
		var url = "";
		if (urlObj.scheme && urlObj.host) {
			url += urlObj.scheme + "://";
		}
		if (urlObj.host) {
			url += urlObj.host;
		}
		if (urlObj.path) {
			url += "/" + urlObj.path;
		}
		if (urlObj.query) {
			url += "?" + urlObj.query;
		}
		if (urlObj.fragment) {
			url += "#" + urlObj.fragment;
		}
		return url;
	};

	var buildSegment = function(segment, remainingAvailableLength){
		var remainingAvailableLengthHalf = remainingAvailableLength/ 2,
				startOffset = Math.ceil(remainingAvailableLengthHalf),
				endOffset = (-1)*Math.floor(remainingAvailableLengthHalf),
				end = "";
		if (endOffset < 0) {
			end = segment.substr(endOffset);
		}
		return segment.substr(0, startOffset) + ellipsisChars + end;
	};
	if (url.length <= truncateLen) {
		return url;
	}
	var availableLength = truncateLen - ellipsisChars.length;
	var urlObj = parse_url(url);
	// Clean up the URL
	if (urlObj.query) {
		var matchQuery = urlObj.query.match(/^(.*?)(?=(\?|\#))(.*?)$/i);
		if (matchQuery) {
			// Malformed URL; two or more "?". Removed any content behind the 2nd.
			urlObj.query = urlObj.query.substr(0, matchQuery[1].length);
			url = buildUrl(urlObj);
		}
	}
	if (url.length <= truncateLen) {
		return url;
	}
	if (urlObj.host) {
		urlObj.host = urlObj.host.replace(/^www\./, "");
		url = buildUrl(urlObj);
	}
	if (url.length <= truncateLen) {
		return url;
	}
	// Process and build the URL
	var str = "";
	if (urlObj.host) {
		str += urlObj.host;
	}
	if (str.length >= availableLength) {
		if (urlObj.host.length == truncateLen) {
			return (urlObj.host.substr(0, (truncateLen - ellipsisChars.length)) + ellipsisChars).substr(0, truncateLen);
		}
		return buildSegment(str, availableLength).substr(0, truncateLen);
	}
	var pathAndQuery = "";
	if (urlObj.path) {
		pathAndQuery += "/" + urlObj.path;
	}
	if (urlObj.query) {
		pathAndQuery += "?" + urlObj.query;
	}
	if (pathAndQuery) {
		if ((str+pathAndQuery).length >= availableLength) {
			if ((str+pathAndQuery).length == truncateLen) {
				return (str + pathAndQuery).substr(0, truncateLen);
			}
			var remainingAvailableLength = availableLength - str.length;
			return (str + buildSegment(pathAndQuery, remainingAvailableLength)).substr(0, truncateLen);
		} else {
			str += pathAndQuery;
		}
	}
	if (urlObj.fragment) {
		var fragment = "#"+urlObj.fragment;
		if ((str+fragment).length >= availableLength) {
			if ((str+fragment).length == truncateLen) {
				return (str + fragment).substr(0, truncateLen);
			}
			var remainingAvailableLength2 = availableLength - str.length;
			return (str + buildSegment(fragment, remainingAvailableLength2)).substr(0, truncateLen);
		} else {
			str += fragment;
		}
	}
	if (urlObj.scheme && urlObj.host) {
		var scheme = urlObj.scheme + "://";
		if ((str+scheme).length < availableLength) {
			return (scheme + str).substr(0, truncateLen);
		}
	}
	if (str.length <= truncateLen) {
		return str;
	}
	var end = "";
	if (availableLength > 0) {
		end = str.substr((-1)*Math.floor(availableLength/2));
	}
	return (str.substr(0, Math.ceil(availableLength/2)) + ellipsisChars + end).substr(0, truncateLen);
};

return Autolinker;
}));
;/*!
 * fancyBox - jQuery Plugin
 * version: 2.1.5 (Fri, 14 Jun 2013)
 * @requires jQuery v1.6 or later
 *
 * Examples at http://fancyapps.com/fancybox/
 * License: www.fancyapps.com/fancybox/#license
 *
 * Copyright 2012 Janis Skarnelis - janis@fancyapps.com
 *
 */

(function (window, document, $, undefined) {
	"use strict";

	var H = $("html"),
		W = $(window),
		D = $(document),
		F = $.fancybox = function () {
			F.open.apply( this, arguments );
		},
		IE =  navigator.userAgent.match(/msie/i),
		didUpdate	= null,
		isTouch		= document.createTouch !== undefined,

		isQuery	= function(obj) {
			return obj && obj.hasOwnProperty && obj instanceof $;
		},
		isString = function(str) {
			return str && $.type(str) === "string";
		},
		isPercentage = function(str) {
			return isString(str) && str.indexOf('%') > 0;
		},
		isScrollable = function(el) {
			return (el && !(el.style.overflow && el.style.overflow === 'hidden') && ((el.clientWidth && el.scrollWidth > el.clientWidth) || (el.clientHeight && el.scrollHeight > el.clientHeight)));
		},
		getScalar = function(orig, dim) {
			var value = parseInt(orig, 10) || 0;

			if (dim && isPercentage(orig)) {
				value = F.getViewport()[ dim ] / 100 * value;
			}

			return Math.ceil(value);
		},
		getValue = function(value, dim) {
			return getScalar(value, dim) + 'px';
		};

	$.extend(F, {
		// The current version of fancyBox
		version: '2.1.5',

		defaults: {
			padding : 15,
			margin  : 20,

			width     : 800,
			height    : 600,
			minWidth  : 100,
			minHeight : 100,
			maxWidth  : 9999,
			maxHeight : 9999,
			pixelRatio: 1, // Set to 2 for retina display support

			autoSize   : true,
			autoHeight : false,
			autoWidth  : false,

			autoResize  : true,
			autoCenter  : !isTouch,
			fitToView   : true,
			aspectRatio : false,
			topRatio    : 0.5,
			leftRatio   : 0.5,

			scrolling : 'auto', // 'auto', 'yes' or 'no'
			wrapCSS   : '',

			arrows     : true,
			closeBtn   : true,
			closeClick : false,
			nextClick  : false,
			mouseWheel : true,
			autoPlay   : false,
			playSpeed  : 3000,
			preload    : 3,
			modal      : false,
			loop       : true,

			ajax  : {
				dataType : 'html',
				headers  : { 'X-fancyBox': true }
			},
			iframe : {
				scrolling : 'auto',
				preload   : true
			},
			swf : {
				wmode: 'transparent',
				allowfullscreen   : 'true',
				allowscriptaccess : 'always'
			},

			keys  : {
				next : {
					13 : 'left', // enter
					34 : 'up',   // page down
					39 : 'left', // right arrow
					40 : 'up'    // down arrow
				},
				prev : {
					8  : 'right',  // backspace
					33 : 'down',   // page up
					37 : 'right',  // left arrow
					38 : 'down'    // up arrow
				},
				close  : [27], // escape key
				play   : [32], // space - start/stop slideshow
				toggle : [70]  // letter "f" - toggle fullscreen
			},

			direction : {
				next : 'left',
				prev : 'right'
			},

			scrollOutside  : true,

			// Override some properties
			index   : 0,
			type    : null,
			href    : null,
			content : null,
			title   : null,

			// HTML templates
			tpl: {
				wrap     : '<div class="fancybox-wrap" tabIndex="-1"><div class="fancybox-skin"><div class="fancybox-outer"><div class="fancybox-inner"></div></div></div></div>',
				image    : '<img class="fancybox-image" src="{href}" alt="" />',
				iframe   : '<iframe id="fancybox-frame{rnd}" name="fancybox-frame{rnd}" class="fancybox-iframe" frameborder="0" vspace="0" hspace="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen' + (IE ? ' allowtransparency="true"' : '') + '></iframe>',
				error    : '<p class="fancybox-error">The requested content cannot be loaded.<br/>Please try again later.</p>',
				closeBtn : '<a title="Close" class="fancybox-item fancybox-close" href="javascript:;"></a>',
				next     : '<a title="Next" class="fancybox-nav fancybox-next" href="javascript:;"><span></span></a>',
				prev     : '<a title="Previous" class="fancybox-nav fancybox-prev" href="javascript:;"><span></span></a>'
			},

			// Properties for each animation type
			// Opening fancyBox
			openEffect  : 'fade', // 'elastic', 'fade' or 'none'
			openSpeed   : 250,
			openEasing  : 'swing',
			openOpacity : true,
			openMethod  : 'zoomIn',

			// Closing fancyBox
			closeEffect  : 'fade', // 'elastic', 'fade' or 'none'
			closeSpeed   : 250,
			closeEasing  : 'swing',
			closeOpacity : true,
			closeMethod  : 'zoomOut',

			// Changing next gallery item
			nextEffect : 'elastic', // 'elastic', 'fade' or 'none'
			nextSpeed  : 250,
			nextEasing : 'swing',
			nextMethod : 'changeIn',

			// Changing previous gallery item
			prevEffect : 'elastic', // 'elastic', 'fade' or 'none'
			prevSpeed  : 250,
			prevEasing : 'swing',
			prevMethod : 'changeOut',

			// Enable default helpers
			helpers : {
				overlay : true,
				title   : true
			},

			// Callbacks
			onCancel     : $.noop, // If canceling
			beforeLoad   : $.noop, // Before loading
			afterLoad    : $.noop, // After loading
			beforeShow   : $.noop, // Before changing in current item
			afterShow    : $.noop, // After opening
			beforeChange : $.noop, // Before changing gallery item
			beforeClose  : $.noop, // Before closing
			afterClose   : $.noop  // After closing
		},

		//Current state
		group    : {}, // Selected group
		opts     : {}, // Group options
		previous : null,  // Previous element
		coming   : null,  // Element being loaded
		current  : null,  // Currently loaded element
		isActive : false, // Is activated
		isOpen   : false, // Is currently open
		isOpened : false, // Have been fully opened at least once

		wrap  : null,
		skin  : null,
		outer : null,
		inner : null,

		player : {
			timer    : null,
			isActive : false
		},

		// Loaders
		ajaxLoad   : null,
		imgPreload : null,

		// Some collections
		transitions : {},
		helpers     : {},

		/*
		 *	Static methods
		 */

		open: function (group, opts) {
			if (!group) {
				return;
			}

			if (!$.isPlainObject(opts)) {
				opts = {};
			}

			// Close if already active
			if (false === F.close(true)) {
				return;
			}

			// Normalize group
			if (!$.isArray(group)) {
				group = isQuery(group) ? $(group).get() : [group];
			}

			// Recheck if the type of each element is `object` and set content type (image, ajax, etc)
			$.each(group, function(i, element) {
				var obj = {},
					href,
					title,
					content,
					type,
					rez,
					hrefParts,
					selector;

				if ($.type(element) === "object") {
					// Check if is DOM element
					if (element.nodeType) {
						element = $(element);
					}

					if (isQuery(element)) {
						obj = {
							href    : element.data('fancybox-href') || element.attr('href'),
							title   : element.data('fancybox-title') || element.attr('title'),
							isDom   : true,
							element : element
						};

						if ($.metadata) {
							$.extend(true, obj, element.metadata());
						}

					} else {
						obj = element;
					}
				}

				href  = opts.href  || obj.href || (isString(element) ? element : null);
				title = opts.title !== undefined ? opts.title : obj.title || '';

				content = opts.content || obj.content;
				type    = content ? 'html' : (opts.type  || obj.type);

				if (!type && obj.isDom) {
					type = element.data('fancybox-type');

					if (!type) {
						rez  = element.prop('class').match(/fancybox\.(\w+)/);
						type = rez ? rez[1] : null;
					}
				}

				if (isString(href)) {
					// Try to guess the content type
					if (!type) {
						if (F.isImage(href)) {
							type = 'image';

						} else if (F.isSWF(href)) {
							type = 'swf';

						} else if (href.charAt(0) === '#') {
							type = 'inline';

						} else if (isString(element)) {
							type    = 'html';
							content = element;
						}
					}

					// Split url into two pieces with source url and content selector, e.g,
					// "/mypage.html #my_id" will load "/mypage.html" and display element having id "my_id"
					if (type === 'ajax') {
						hrefParts = href.split(/\s+/, 2);
						href      = hrefParts.shift();
						selector  = hrefParts.shift();
					}
				}

				if (!content) {
					if (type === 'inline') {
						if (href) {
							content = $( isString(href) ? href.replace(/.*(?=#[^\s]+$)/, '') : href ); //strip for ie7

						} else if (obj.isDom) {
							content = element;
						}

					} else if (type === 'html') {
						content = href;

					} else if (!type && !href && obj.isDom) {
						type    = 'inline';
						content = element;
					}
				}

				$.extend(obj, {
					href     : href,
					type     : type,
					content  : content,
					title    : title,
					selector : selector
				});

				group[ i ] = obj;
			});

			// Extend the defaults
			F.opts = $.extend(true, {}, F.defaults, opts);

			// All options are merged recursive except keys
			if (opts.keys !== undefined) {
				F.opts.keys = opts.keys ? $.extend({}, F.defaults.keys, opts.keys) : false;
			}

			F.group = group;

			return F._start(F.opts.index);
		},

		// Cancel image loading or abort ajax request
		cancel: function () {
			var coming = F.coming;

			if (!coming || false === F.trigger('onCancel')) {
				return;
			}

			F.hideLoading();

			if (F.ajaxLoad) {
				F.ajaxLoad.abort();
			}

			F.ajaxLoad = null;

			if (F.imgPreload) {
				F.imgPreload.onload = F.imgPreload.onerror = null;
			}

			if (coming.wrap) {
				coming.wrap.stop(true, true).trigger('onReset').remove();
			}

			F.coming = null;

			// If the first item has been canceled, then clear everything
			if (!F.current) {
				F._afterZoomOut( coming );
			}
		},

		// Start closing animation if is open; remove immediately if opening/closing
		close: function (event) {
			F.cancel();

			if (false === F.trigger('beforeClose')) {
				return;
			}

			F.unbindEvents();

			if (!F.isActive) {
				return;
			}

			if (!F.isOpen || event === true) {
				$('.fancybox-wrap').stop(true).trigger('onReset').remove();

				F._afterZoomOut();

			} else {
				F.isOpen = F.isOpened = false;
				F.isClosing = true;

				$('.fancybox-item, .fancybox-nav').remove();

				F.wrap.stop(true, true).removeClass('fancybox-opened');

				F.transitions[ F.current.closeMethod ]();
			}
		},

		// Manage slideshow:
		//   $.fancybox.play(); - toggle slideshow
		//   $.fancybox.play( true ); - start
		//   $.fancybox.play( false ); - stop
		play: function ( action ) {
			var clear = function () {
					clearTimeout(F.player.timer);
				},
				set = function () {
					clear();

					if (F.current && F.player.isActive) {
						F.player.timer = setTimeout(F.next, F.current.playSpeed);
					}
				},
				stop = function () {
					clear();

					D.unbind('.player');

					F.player.isActive = false;

					F.trigger('onPlayEnd');
				},
				start = function () {
					if (F.current && (F.current.loop || F.current.index < F.group.length - 1)) {
						F.player.isActive = true;

						D.bind({
							'onCancel.player beforeClose.player' : stop,
							'onUpdate.player'   : set,
							'beforeLoad.player' : clear
						});

						set();

						F.trigger('onPlayStart');
					}
				};

			if (action === true || (!F.player.isActive && action !== false)) {
				start();
			} else {
				stop();
			}
		},

		// Navigate to next gallery item
		next: function ( direction ) {
			var current = F.current;

			if (current) {
				if (!isString(direction)) {
					direction = current.direction.next;
				}

				F.jumpto(current.index + 1, direction, 'next');
			}
		},

		// Navigate to previous gallery item
		prev: function ( direction ) {
			var current = F.current;

			if (current) {
				if (!isString(direction)) {
					direction = current.direction.prev;
				}

				F.jumpto(current.index - 1, direction, 'prev');
			}
		},

		// Navigate to gallery item by index
		jumpto: function ( index, direction, router ) {
			var current = F.current;

			if (!current) {
				return;
			}

			index = getScalar(index);

			F.direction = direction || current.direction[ (index >= current.index ? 'next' : 'prev') ];
			F.router    = router || 'jumpto';

			if (current.loop) {
				if (index < 0) {
					index = current.group.length + (index % current.group.length);
				}

				index = index % current.group.length;
			}

			if (current.group[ index ] !== undefined) {
				F.cancel();

				F._start(index);
			}
		},

		// Center inside viewport and toggle position type to fixed or absolute if needed
		reposition: function (e, onlyAbsolute) {
			var current = F.current,
				wrap    = current ? current.wrap : null,
				pos;

			if (wrap) {
				pos = F._getPosition(onlyAbsolute);

				if (e && e.type === 'scroll') {
					delete pos.position;

					wrap.stop(true, true).animate(pos, 200);

				} else {
					wrap.css(pos);

					current.pos = $.extend({}, current.dim, pos);
				}
			}
		},

		update: function (e) {
			var type = (e && e.type),
				anyway = !type || type === 'orientationchange';

			if (anyway) {
				clearTimeout(didUpdate);

				didUpdate = null;
			}

			if (!F.isOpen || didUpdate) {
				return;
			}

			didUpdate = setTimeout(function() {
				var current = F.current;

				if (!current || F.isClosing) {
					return;
				}

				F.wrap.removeClass('fancybox-tmp');

				if (anyway || type === 'load' || (type === 'resize' && current.autoResize)) {
					F._setDimension();
				}

				if (!(type === 'scroll' && current.canShrink)) {
					F.reposition(e);
				}

				F.trigger('onUpdate');

				didUpdate = null;

			}, (anyway && !isTouch ? 0 : 300));
		},

		// Shrink content to fit inside viewport or restore if resized
		toggle: function ( action ) {
			if (F.isOpen) {
				F.current.fitToView = $.type(action) === "boolean" ? action : !F.current.fitToView;

				// Help browser to restore document dimensions
				if (isTouch) {
					F.wrap.removeAttr('style').addClass('fancybox-tmp');

					F.trigger('onUpdate');
				}

				F.update();
			}
		},

		hideLoading: function () {
			D.unbind('.loading');

			$('#fancybox-loading').remove();
		},

		showLoading: function () {
			var el, viewport;

			F.hideLoading();

			el = $('<div id="fancybox-loading"><div></div></div>').click(F.cancel).appendTo('body');

			// If user will press the escape-button, the request will be canceled
			D.bind('keydown.loading', function(e) {
				if ((e.which || e.keyCode) === 27) {
					e.preventDefault();

					F.cancel();
				}
			});

			if (!F.defaults.fixed) {
				viewport = F.getViewport();

				el.css({
					position : 'absolute',
					top  : (viewport.h * 0.5) + viewport.y,
					left : (viewport.w * 0.5) + viewport.x
				});
			}
		},

		getViewport: function () {
			var locked = (F.current && F.current.locked) || false,
				rez    = {
					x: W.scrollLeft(),
					y: W.scrollTop()
				};

			if (locked) {
				rez.w = locked[0].clientWidth;
				rez.h = locked[0].clientHeight;

			} else {
				// See http://bugs.jquery.com/ticket/6724
				rez.w = isTouch && window.innerWidth  ? window.innerWidth  : W.width();
				rez.h = isTouch && window.innerHeight ? window.innerHeight : W.height();
			}

			return rez;
		},

		// Unbind the keyboard / clicking actions
		unbindEvents: function () {
			if (F.wrap && isQuery(F.wrap)) {
				F.wrap.unbind('.fb');
			}

			D.unbind('.fb');
			W.unbind('.fb');
		},

		bindEvents: function () {
			var current = F.current,
				keys;

			if (!current) {
				return;
			}

			// Changing document height on iOS devices triggers a 'resize' event,
			// that can change document height... repeating infinitely
			W.bind('orientationchange.fb' + (isTouch ? '' : ' resize.fb') + (current.autoCenter && !current.locked ? ' scroll.fb' : ''), F.update);

			keys = current.keys;

			if (keys) {
				D.bind('keydown.fb', function (e) {
					var code   = e.which || e.keyCode,
						target = e.target || e.srcElement;

					// Skip esc key if loading, because showLoading will cancel preloading
					if (code === 27 && F.coming) {
						return false;
					}

					// Ignore key combinations and key events within form elements
					if (!e.ctrlKey && !e.altKey && !e.shiftKey && !e.metaKey && !(target && (target.type || $(target).is('[contenteditable]')))) {
						$.each(keys, function(i, val) {
							if (current.group.length > 1 && val[ code ] !== undefined) {
								F[ i ]( val[ code ] );

								e.preventDefault();
								return false;
							}

							if ($.inArray(code, val) > -1) {
								F[ i ] ();

								e.preventDefault();
								return false;
							}
						});
					}
				});
			}

			if ($.fn.mousewheel && current.mouseWheel) {
				F.wrap.bind('mousewheel.fb', function (e, delta, deltaX, deltaY) {
					var target = e.target || null,
						parent = $(target),
						canScroll = false;

					while (parent.length) {
						if (canScroll || parent.is('.fancybox-skin') || parent.is('.fancybox-wrap')) {
							break;
						}

						canScroll = isScrollable( parent[0] );
						parent    = $(parent).parent();
					}

					if (delta !== 0 && !canScroll) {
						if (F.group.length > 1 && !current.canShrink) {
							if (deltaY > 0 || deltaX > 0) {
								F.prev( deltaY > 0 ? 'down' : 'left' );

							} else if (deltaY < 0 || deltaX < 0) {
								F.next( deltaY < 0 ? 'up' : 'right' );
							}

							e.preventDefault();
						}
					}
				});
			}
		},

		trigger: function (event, o) {
			var ret, obj = o || F.coming || F.current;

			if (!obj) {
				return;
			}

			if ($.isFunction( obj[event] )) {
				ret = obj[event].apply(obj, Array.prototype.slice.call(arguments, 1));
			}

			if (ret === false) {
				return false;
			}

			if (obj.helpers) {
				$.each(obj.helpers, function (helper, opts) {
					if (opts && F.helpers[helper] && $.isFunction(F.helpers[helper][event])) {
						F.helpers[helper][event]($.extend(true, {}, F.helpers[helper].defaults, opts), obj);
					}
				});
			}

			D.trigger(event);
		},

		isImage: function (str) {
			return isString(str) && str.match(/(^data:image\/.*,)|(\.(jp(e|g|eg)|gif|png|bmp|webp|svg)((\?|#).*)?$)/i);
		},

		isSWF: function (str) {
			return isString(str) && str.match(/\.(swf)((\?|#).*)?$/i);
		},

		_start: function (index) {
			var coming = {},
				obj,
				href,
				type,
				margin,
				padding;

			index = getScalar( index );
			obj   = F.group[ index ] || null;

			if (!obj) {
				return false;
			}

			coming = $.extend(true, {}, F.opts, obj);

			// Convert margin and padding properties to array - top, right, bottom, left
			margin  = coming.margin;
			padding = coming.padding;

			if ($.type(margin) === 'number') {
				coming.margin = [margin, margin, margin, margin];
			}

			if ($.type(padding) === 'number') {
				coming.padding = [padding, padding, padding, padding];
			}

			// 'modal' propery is just a shortcut
			if (coming.modal) {
				$.extend(true, coming, {
					closeBtn   : false,
					closeClick : false,
					nextClick  : false,
					arrows     : false,
					mouseWheel : false,
					keys       : null,
					helpers: {
						overlay : {
							closeClick : false
						}
					}
				});
			}

			// 'autoSize' property is a shortcut, too
			if (coming.autoSize) {
				coming.autoWidth = coming.autoHeight = true;
			}

			if (coming.width === 'auto') {
				coming.autoWidth = true;
			}

			if (coming.height === 'auto') {
				coming.autoHeight = true;
			}

			/*
			 * Add reference to the group, so it`s possible to access from callbacks, example:
			 * afterLoad : function() {
			 *     this.title = 'Image ' + (this.index + 1) + ' of ' + this.group.length + (this.title ? ' - ' + this.title : '');
			 * }
			 */

			coming.group  = F.group;
			coming.index  = index;

			// Give a chance for callback or helpers to update coming item (type, title, etc)
			F.coming = coming;

			if (false === F.trigger('beforeLoad')) {
				F.coming = null;

				return;
			}

			type = coming.type;
			href = coming.href;

			if (!type) {
				F.coming = null;

				//If we can not determine content type then drop silently or display next/prev item if looping through gallery
				if (F.current && F.router && F.router !== 'jumpto') {
					F.current.index = index;

					return F[ F.router ]( F.direction );
				}

				return false;
			}

			F.isActive = true;

			if (type === 'image' || type === 'swf') {
				coming.autoHeight = coming.autoWidth = false;
				coming.scrolling  = 'visible';
			}

			if (type === 'image') {
				coming.aspectRatio = true;
			}

			if (type === 'iframe' && isTouch) {
				coming.scrolling = 'scroll';
			}

			// Build the neccessary markup
			coming.wrap = $(coming.tpl.wrap).addClass('fancybox-' + (isTouch ? 'mobile' : 'desktop') + ' fancybox-type-' + type + ' fancybox-tmp ' + coming.wrapCSS).appendTo( coming.parent || 'body' );

			$.extend(coming, {
				skin  : $('.fancybox-skin',  coming.wrap),
				outer : $('.fancybox-outer', coming.wrap),
				inner : $('.fancybox-inner', coming.wrap)
			});

			$.each(["Top", "Right", "Bottom", "Left"], function(i, v) {
				coming.skin.css('padding' + v, getValue(coming.padding[ i ]));
			});

			F.trigger('onReady');

			// Check before try to load; 'inline' and 'html' types need content, others - href
			if (type === 'inline' || type === 'html') {
				if (!coming.content || !coming.content.length) {
					return F._error( 'content' );
				}

			} else if (!href) {
				return F._error( 'href' );
			}

			if (type === 'image') {
				F._loadImage();

			} else if (type === 'ajax') {
				F._loadAjax();

			} else if (type === 'iframe') {
				F._loadIframe();

			} else {
				F._afterLoad();
			}
		},

		_error: function ( type ) {
			$.extend(F.coming, {
				type       : 'html',
				autoWidth  : true,
				autoHeight : true,
				minWidth   : 0,
				minHeight  : 0,
				scrolling  : 'no',
				hasError   : type,
				content    : F.coming.tpl.error
			});

			F._afterLoad();
		},

		_loadImage: function () {
			// Reset preload image so it is later possible to check "complete" property
			var img = F.imgPreload = new Image();

			img.onload = function () {
				this.onload = this.onerror = null;

				F.coming.width  = this.width / F.opts.pixelRatio;
				F.coming.height = this.height / F.opts.pixelRatio;

				F._afterLoad();
			};

			img.onerror = function () {
				this.onload = this.onerror = null;

				F._error( 'image' );
			};

			img.src = F.coming.href;

			if (img.complete !== true) {
				F.showLoading();
			}
		},

		_loadAjax: function () {
			var coming = F.coming;

			F.showLoading();

			F.ajaxLoad = $.ajax($.extend({}, coming.ajax, {
				url: coming.href,
				error: function (jqXHR, textStatus) {
					if (F.coming && textStatus !== 'abort') {
						F._error( 'ajax', jqXHR );

					} else {
						F.hideLoading();
					}
				},
				success: function (data, textStatus) {
					if (textStatus === 'success') {
						coming.content = data;

						F._afterLoad();
					}
				}
			}));
		},

		_loadIframe: function() {
			var coming = F.coming,
				iframe = $(coming.tpl.iframe.replace(/\{rnd\}/g, new Date().getTime()))
					.attr('scrolling', isTouch ? 'auto' : coming.iframe.scrolling)
					.attr('src', coming.href);

			// This helps IE
			$(coming.wrap).bind('onReset', function () {
				try {
					$(this).find('iframe').hide().attr('src', '//about:blank').end().empty();
				} catch (e) {}
			});

			if (coming.iframe.preload) {
				F.showLoading();

				iframe.one('load', function() {
					$(this).data('ready', 1);

					// iOS will lose scrolling if we resize
					if (!isTouch) {
						$(this).bind('load.fb', F.update);
					}

					// Without this trick:
					//   - iframe won't scroll on iOS devices
					//   - IE7 sometimes displays empty iframe
					$(this).parents('.fancybox-wrap').width('100%').removeClass('fancybox-tmp').show();

					F._afterLoad();
				});
			}

			coming.content = iframe.appendTo( coming.inner );

			if (!coming.iframe.preload) {
				F._afterLoad();
			}
		},

		_preloadImages: function() {
			var group   = F.group,
				current = F.current,
				len     = group.length,
				cnt     = current.preload ? Math.min(current.preload, len - 1) : 0,
				item,
				i;

			for (i = 1; i <= cnt; i += 1) {
				item = group[ (current.index + i ) % len ];

				if (item.type === 'image' && item.href) {
					new Image().src = item.href;
				}
			}
		},

		_afterLoad: function () {
			var coming   = F.coming,
				previous = F.current,
				placeholder = 'fancybox-placeholder',
				current,
				content,
				type,
				scrolling,
				href,
				embed;

			F.hideLoading();

			if (!coming || F.isActive === false) {
				return;
			}

			if (false === F.trigger('afterLoad', coming, previous)) {
				coming.wrap.stop(true).trigger('onReset').remove();

				F.coming = null;

				return;
			}

			if (previous) {
				F.trigger('beforeChange', previous);

				previous.wrap.stop(true).removeClass('fancybox-opened')
					.find('.fancybox-item, .fancybox-nav')
					.remove();
			}

			F.unbindEvents();

			current   = coming;
			content   = coming.content;
			type      = coming.type;
			scrolling = coming.scrolling;

			$.extend(F, {
				wrap  : current.wrap,
				skin  : current.skin,
				outer : current.outer,
				inner : current.inner,
				current  : current,
				previous : previous
			});

			href = current.href;

			switch (type) {
				case 'inline':
				case 'ajax':
				case 'html':
					if (current.selector) {
						content = $('<div>').html(content).find(current.selector);

					} else if (isQuery(content)) {
						if (!content.data(placeholder)) {
							content.data(placeholder, $('<div class="' + placeholder + '"></div>').insertAfter( content ).hide() );
						}

						content = content.show().detach();

						current.wrap.bind('onReset', function () {
							if ($(this).find(content).length) {
								content.hide().replaceAll( content.data(placeholder) ).data(placeholder, false);
							}
						});
					}
				break;

				case 'image':
					content = current.tpl.image.replace('{href}', href);
				break;

				case 'swf':
					content = '<object id="fancybox-swf" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="100%" height="100%"><param name="movie" value="' + href + '"></param>';
					embed   = '';

					$.each(current.swf, function(name, val) {
						content += '<param name="' + name + '" value="' + val + '"></param>';
						embed   += ' ' + name + '="' + val + '"';
					});

					content += '<embed src="' + href + '" type="application/x-shockwave-flash" width="100%" height="100%"' + embed + '></embed></object>';
				break;
			}

			if (!(isQuery(content) && content.parent().is(current.inner))) {
				current.inner.append( content );
			}

			// Give a chance for helpers or callbacks to update elements
			F.trigger('beforeShow');

			// Set scrolling before calculating dimensions
			current.inner.css('overflow', scrolling === 'yes' ? 'scroll' : (scrolling === 'no' ? 'hidden' : scrolling));

			// Set initial dimensions and start position
			F._setDimension();

			F.reposition();

			F.isOpen = false;
			F.coming = null;

			F.bindEvents();

			if (!F.isOpened) {
				$('.fancybox-wrap').not( current.wrap ).stop(true).trigger('onReset').remove();

			} else if (previous.prevMethod) {
				F.transitions[ previous.prevMethod ]();
			}

			F.transitions[ F.isOpened ? current.nextMethod : current.openMethod ]();

			F._preloadImages();
		},

		_setDimension: function () {
			var viewport   = F.getViewport(),
				steps      = 0,
				canShrink  = false,
				canExpand  = false,
				wrap       = F.wrap,
				skin       = F.skin,
				inner      = F.inner,
				current    = F.current,
				width      = current.width,
				height     = current.height,
				minWidth   = current.minWidth,
				minHeight  = current.minHeight,
				maxWidth   = current.maxWidth,
				maxHeight  = current.maxHeight,
				scrolling  = current.scrolling,
				scrollOut  = current.scrollOutside ? current.scrollbarWidth : 0,
				margin     = current.margin,
				wMargin    = getScalar(margin[1] + margin[3]),
				hMargin    = getScalar(margin[0] + margin[2]),
				wPadding,
				hPadding,
				wSpace,
				hSpace,
				origWidth,
				origHeight,
				origMaxWidth,
				origMaxHeight,
				ratio,
				width_,
				height_,
				maxWidth_,
				maxHeight_,
				iframe,
				body;

			// Reset dimensions so we could re-check actual size
			wrap.add(skin).add(inner).width('auto').height('auto').removeClass('fancybox-tmp');

			wPadding = getScalar(skin.outerWidth(true)  - skin.width());
			hPadding = getScalar(skin.outerHeight(true) - skin.height());

			// Any space between content and viewport (margin, padding, border, title)
			wSpace = wMargin + wPadding;
			hSpace = hMargin + hPadding;

			origWidth  = isPercentage(width)  ? (viewport.w - wSpace) * getScalar(width)  / 100 : width;
			origHeight = isPercentage(height) ? (viewport.h - hSpace) * getScalar(height) / 100 : height;

			if (current.type === 'iframe') {
				iframe = current.content;

				if (current.autoHeight && iframe.data('ready') === 1) {
					try {
						if (iframe[0].contentWindow.document.location) {
							inner.width( origWidth ).height(9999);

							body = iframe.contents().find('body');

							if (scrollOut) {
								body.css('overflow-x', 'hidden');
							}

							origHeight = body.outerHeight(true);
						}

					} catch (e) {}
				}

			} else if (current.autoWidth || current.autoHeight) {
				inner.addClass( 'fancybox-tmp' );

				// Set width or height in case we need to calculate only one dimension
				if (!current.autoWidth) {
					inner.width( origWidth );
				}

				if (!current.autoHeight) {
					inner.height( origHeight );
				}

				if (current.autoWidth) {
					origWidth = inner.width();
				}

				if (current.autoHeight) {
					origHeight = inner.height();
				}

				inner.removeClass( 'fancybox-tmp' );
			}

			width  = getScalar( origWidth );
			height = getScalar( origHeight );

			ratio  = origWidth / origHeight;

			// Calculations for the content
			minWidth  = getScalar(isPercentage(minWidth) ? getScalar(minWidth, 'w') - wSpace : minWidth);
			maxWidth  = getScalar(isPercentage(maxWidth) ? getScalar(maxWidth, 'w') - wSpace : maxWidth);

			minHeight = getScalar(isPercentage(minHeight) ? getScalar(minHeight, 'h') - hSpace : minHeight);
			maxHeight = getScalar(isPercentage(maxHeight) ? getScalar(maxHeight, 'h') - hSpace : maxHeight);

			// These will be used to determine if wrap can fit in the viewport
			origMaxWidth  = maxWidth;
			origMaxHeight = maxHeight;

			if (current.fitToView) {
				maxWidth  = Math.min(viewport.w - wSpace, maxWidth);
				maxHeight = Math.min(viewport.h - hSpace, maxHeight);
			}

			maxWidth_  = viewport.w - wMargin;
			maxHeight_ = viewport.h - hMargin;

			if (current.aspectRatio) {
				if (width > maxWidth) {
					width  = maxWidth;
					height = getScalar(width / ratio);
				}

				if (height > maxHeight) {
					height = maxHeight;
					width  = getScalar(height * ratio);
				}

				if (width < minWidth) {
					width  = minWidth;
					height = getScalar(width / ratio);
				}

				if (height < minHeight) {
					height = minHeight;
					width  = getScalar(height * ratio);
				}

			} else {
				width = Math.max(minWidth, Math.min(width, maxWidth));

				if (current.autoHeight && current.type !== 'iframe') {
					inner.width( width );

					height = inner.height();
				}

				height = Math.max(minHeight, Math.min(height, maxHeight));
			}

			// Try to fit inside viewport (including the title)
			if (current.fitToView) {
				inner.width( width ).height( height );

				wrap.width( width + wPadding );

				// Real wrap dimensions
				width_  = wrap.width();
				height_ = wrap.height();

				if (current.aspectRatio) {
					while ((width_ > maxWidth_ || height_ > maxHeight_) && width > minWidth && height > minHeight) {
						if (steps++ > 19) {
							break;
						}

						height = Math.max(minHeight, Math.min(maxHeight, height - 10));
						width  = getScalar(height * ratio);

						if (width < minWidth) {
							width  = minWidth;
							height = getScalar(width / ratio);
						}

						if (width > maxWidth) {
							width  = maxWidth;
							height = getScalar(width / ratio);
						}

						inner.width( width ).height( height );

						wrap.width( width + wPadding );

						width_  = wrap.width();
						height_ = wrap.height();
					}

				} else {
					width  = Math.max(minWidth,  Math.min(width,  width  - (width_  - maxWidth_)));
					height = Math.max(minHeight, Math.min(height, height - (height_ - maxHeight_)));
				}
			}

			if (scrollOut && scrolling === 'auto' && height < origHeight && (width + wPadding + scrollOut) < maxWidth_) {
				width += scrollOut;
			}

			inner.width( width ).height( height );

			wrap.width( width + wPadding );

			width_  = wrap.width();
			height_ = wrap.height();

			canShrink = (width_ > maxWidth_ || height_ > maxHeight_) && width > minWidth && height > minHeight;
			canExpand = current.aspectRatio ? (width < origMaxWidth && height < origMaxHeight && width < origWidth && height < origHeight) : ((width < origMaxWidth || height < origMaxHeight) && (width < origWidth || height < origHeight));

			$.extend(current, {
				dim : {
					width	: getValue( width_ ),
					height	: getValue( height_ )
				},
				origWidth  : origWidth,
				origHeight : origHeight,
				canShrink  : canShrink,
				canExpand  : canExpand,
				wPadding   : wPadding,
				hPadding   : hPadding,
				wrapSpace  : height_ - skin.outerHeight(true),
				skinSpace  : skin.height() - height
			});

			if (!iframe && current.autoHeight && height > minHeight && height < maxHeight && !canExpand) {
				inner.height('auto');
			}
		},

		_getPosition: function (onlyAbsolute) {
			var current  = F.current,
				viewport = F.getViewport(),
				margin   = current.margin,
				width    = F.wrap.width()  + margin[1] + margin[3],
				height   = F.wrap.height() + margin[0] + margin[2],
				rez      = {
					position: 'absolute',
					top  : margin[0],
					left : margin[3]
				};

			if (current.autoCenter && current.fixed && !onlyAbsolute && height <= viewport.h && width <= viewport.w) {
				rez.position = 'fixed';

			} else if (!current.locked) {
				rez.top  += viewport.y;
				rez.left += viewport.x;
			}

			rez.top  = getValue(Math.max(rez.top,  rez.top  + ((viewport.h - height) * current.topRatio)));
			rez.left = getValue(Math.max(rez.left, rez.left + ((viewport.w - width)  * current.leftRatio)));

			return rez;
		},

		_afterZoomIn: function () {
			var current = F.current;

			if (!current) {
				return;
			}

			F.isOpen = F.isOpened = true;

			F.wrap.css('overflow', 'visible').addClass('fancybox-opened');

			F.update();

			// Assign a click event
			if ( current.closeClick || (current.nextClick && F.group.length > 1) ) {
				F.inner.css('cursor', 'pointer').bind('click.fb', function(e) {
					if (!$(e.target).is('a') && !$(e.target).parent().is('a')) {
						e.preventDefault();

						F[ current.closeClick ? 'close' : 'next' ]();
					}
				});
			}

			// Create a close button
			if (current.closeBtn) {
				$(current.tpl.closeBtn).appendTo(F.skin).bind('click.fb', function(e) {
					e.preventDefault();

					F.close();
				});
			}

			// Create navigation arrows
			if (current.arrows && F.group.length > 1) {
				if (current.loop || current.index > 0) {
					$(current.tpl.prev).appendTo(F.outer).bind('click.fb', F.prev);
				}

				if (current.loop || current.index < F.group.length - 1) {
					$(current.tpl.next).appendTo(F.outer).bind('click.fb', F.next);
				}
			}

			F.trigger('afterShow');

			// Stop the slideshow if this is the last item
			if (!current.loop && current.index === current.group.length - 1) {
				F.play( false );

			} else if (F.opts.autoPlay && !F.player.isActive) {
				F.opts.autoPlay = false;

				F.play();
			}
		},

		_afterZoomOut: function ( obj ) {
			obj = obj || F.current;

			$('.fancybox-wrap').trigger('onReset').remove();

			$.extend(F, {
				group  : {},
				opts   : {},
				router : false,
				current   : null,
				isActive  : false,
				isOpened  : false,
				isOpen    : false,
				isClosing : false,
				wrap   : null,
				skin   : null,
				outer  : null,
				inner  : null
			});

			F.trigger('afterClose', obj);
		}
	});

	/*
	 *	Default transitions
	 */

	F.transitions = {
		getOrigPosition: function () {
			var current  = F.current,
				element  = current.element,
				orig     = current.orig,
				pos      = {},
				width    = 50,
				height   = 50,
				hPadding = current.hPadding,
				wPadding = current.wPadding,
				viewport = F.getViewport();

			if (!orig && current.isDom && element.is(':visible')) {
				orig = element.find('img:first');

				if (!orig.length) {
					orig = element;
				}
			}

			if (isQuery(orig)) {
				pos = orig.offset();

				if (orig.is('img')) {
					width  = orig.outerWidth();
					height = orig.outerHeight();
				}

			} else {
				pos.top  = viewport.y + (viewport.h - height) * current.topRatio;
				pos.left = viewport.x + (viewport.w - width)  * current.leftRatio;
			}

			if (F.wrap.css('position') === 'fixed' || current.locked) {
				pos.top  -= viewport.y;
				pos.left -= viewport.x;
			}

			pos = {
				top     : getValue(pos.top  - hPadding * current.topRatio),
				left    : getValue(pos.left - wPadding * current.leftRatio),
				width   : getValue(width  + wPadding),
				height  : getValue(height + hPadding)
			};

			return pos;
		},

		step: function (now, fx) {
			var ratio,
				padding,
				value,
				prop       = fx.prop,
				current    = F.current,
				wrapSpace  = current.wrapSpace,
				skinSpace  = current.skinSpace;

			if (prop === 'width' || prop === 'height') {
				ratio = fx.end === fx.start ? 1 : (now - fx.start) / (fx.end - fx.start);

				if (F.isClosing) {
					ratio = 1 - ratio;
				}

				padding = prop === 'width' ? current.wPadding : current.hPadding;
				value   = now - padding;

				F.skin[ prop ](  getScalar( prop === 'width' ?  value : value - (wrapSpace * ratio) ) );
				F.inner[ prop ]( getScalar( prop === 'width' ?  value : value - (wrapSpace * ratio) - (skinSpace * ratio) ) );
			}
		},

		zoomIn: function () {
			var current  = F.current,
				startPos = current.pos,
				effect   = current.openEffect,
				elastic  = effect === 'elastic',
				endPos   = $.extend({opacity : 1}, startPos);

			// Remove "position" property that breaks older IE
			delete endPos.position;

			if (elastic) {
				startPos = this.getOrigPosition();

				if (current.openOpacity) {
					startPos.opacity = 0.1;
				}

			} else if (effect === 'fade') {
				startPos.opacity = 0.1;
			}

			F.wrap.css(startPos).animate(endPos, {
				duration : effect === 'none' ? 0 : current.openSpeed,
				easing   : current.openEasing,
				step     : elastic ? this.step : null,
				complete : F._afterZoomIn
			});
		},

		zoomOut: function () {
			var current  = F.current,
				effect   = current.closeEffect,
				elastic  = effect === 'elastic',
				endPos   = {opacity : 0.1};

			if (elastic) {
				endPos = this.getOrigPosition();

				if (current.closeOpacity) {
					endPos.opacity = 0.1;
				}
			}

			F.wrap.animate(endPos, {
				duration : effect === 'none' ? 0 : current.closeSpeed,
				easing   : current.closeEasing,
				step     : elastic ? this.step : null,
				complete : F._afterZoomOut
			});
		},

		changeIn: function () {
			var current   = F.current,
				effect    = current.nextEffect,
				startPos  = current.pos,
				endPos    = { opacity : 1 },
				direction = F.direction,
				distance  = 200,
				field;

			startPos.opacity = 0.1;

			if (effect === 'elastic') {
				field = direction === 'down' || direction === 'up' ? 'top' : 'left';

				if (direction === 'down' || direction === 'right') {
					startPos[ field ] = getValue(getScalar(startPos[ field ]) - distance);
					endPos[ field ]   = '+=' + distance + 'px';

				} else {
					startPos[ field ] = getValue(getScalar(startPos[ field ]) + distance);
					endPos[ field ]   = '-=' + distance + 'px';
				}
			}

			// Workaround for http://bugs.jquery.com/ticket/12273
			if (effect === 'none') {
				F._afterZoomIn();

			} else {
				F.wrap.css(startPos).animate(endPos, {
					duration : current.nextSpeed,
					easing   : current.nextEasing,
					complete : F._afterZoomIn
				});
			}
		},

		changeOut: function () {
			var previous  = F.previous,
				effect    = previous.prevEffect,
				endPos    = { opacity : 0.1 },
				direction = F.direction,
				distance  = 200;

			if (effect === 'elastic') {
				endPos[ direction === 'down' || direction === 'up' ? 'top' : 'left' ] = ( direction === 'up' || direction === 'left' ? '-' : '+' ) + '=' + distance + 'px';
			}

			previous.wrap.animate(endPos, {
				duration : effect === 'none' ? 0 : previous.prevSpeed,
				easing   : previous.prevEasing,
				complete : function () {
					$(this).trigger('onReset').remove();
				}
			});
		}
	};

	/*
	 *	Overlay helper
	 */

	F.helpers.overlay = {
		defaults : {
			closeClick : true,      // if true, fancyBox will be closed when user clicks on the overlay
			speedOut   : 200,       // duration of fadeOut animation
			showEarly  : true,      // indicates if should be opened immediately or wait until the content is ready
			css        : {},        // custom CSS properties
			locked     : !isTouch,  // if true, the content will be locked into overlay
			fixed      : true       // if false, the overlay CSS position property will not be set to "fixed"
		},

		overlay : null,      // current handle
		fixed   : false,     // indicates if the overlay has position "fixed"
		el      : $('html'), // element that contains "the lock"

		// Public methods
		create : function(opts) {
			opts = $.extend({}, this.defaults, opts);

			if (this.overlay) {
				this.close();
			}

			this.overlay = $('<div class="fancybox-overlay"></div>').appendTo( F.coming ? F.coming.parent : opts.parent );
			this.fixed   = false;

			if (opts.fixed && F.defaults.fixed) {
				this.overlay.addClass('fancybox-overlay-fixed');

				this.fixed = true;
			}
		},

		open : function(opts) {
			var that = this;

			opts = $.extend({}, this.defaults, opts);

			if (this.overlay) {
				this.overlay.unbind('.overlay').width('auto').height('auto');

			} else {
				this.create(opts);
			}

			if (!this.fixed) {
				W.bind('resize.overlay', $.proxy( this.update, this) );

				this.update();
			}

			if (opts.closeClick) {
				this.overlay.bind('click.overlay', function(e) {
					if ($(e.target).hasClass('fancybox-overlay')) {
						if (F.isActive) {
							F.close();
						} else {
							that.close();
						}

						return false;
					}
				});
			}

			this.overlay.css( opts.css ).show();
		},

		close : function() {
			var scrollV, scrollH;

			W.unbind('resize.overlay');

			if (this.el.hasClass('fancybox-lock')) {
				$('.fancybox-margin').removeClass('fancybox-margin');

				scrollV = W.scrollTop();
				scrollH = W.scrollLeft();

				this.el.removeClass('fancybox-lock');

				W.scrollTop( scrollV ).scrollLeft( scrollH );
			}

			$('.fancybox-overlay').remove().hide();

			$.extend(this, {
				overlay : null,
				fixed   : false
			});
		},

		// Private, callbacks

		update : function () {
			var width = '100%', offsetWidth;

			// Reset width/height so it will not mess
			this.overlay.width(width).height('100%');

			// jQuery does not return reliable result for IE
			if (IE) {
				offsetWidth = Math.max(document.documentElement.offsetWidth, document.body.offsetWidth);

				if (D.width() > offsetWidth) {
					width = D.width();
				}

			} else if (D.width() > W.width()) {
				width = D.width();
			}

			this.overlay.width(width).height(D.height());
		},

		// This is where we can manipulate DOM, because later it would cause iframes to reload
		onReady : function (opts, obj) {
			var overlay = this.overlay;

			$('.fancybox-overlay').stop(true, true);

			if (!overlay) {
				this.create(opts);
			}

			if (opts.locked && this.fixed && obj.fixed) {
				if (!overlay) {
					this.margin = D.height() > W.height() ? $('html').css('margin-right').replace("px", "") : false;
				}

				obj.locked = this.overlay.append( obj.wrap );
				obj.fixed  = false;
			}

			if (opts.showEarly === true) {
				this.beforeShow.apply(this, arguments);
			}
		},

		beforeShow : function(opts, obj) {
			var scrollV, scrollH;

			if (obj.locked) {
				if (this.margin !== false) {
					$('*').filter(function(){
						return ($(this).css('position') === 'fixed' && !$(this).hasClass("fancybox-overlay") && !$(this).hasClass("fancybox-wrap") );
					}).addClass('fancybox-margin');

					this.el.addClass('fancybox-margin');
				}

				scrollV = W.scrollTop();
				scrollH = W.scrollLeft();

				this.el.addClass('fancybox-lock');

				W.scrollTop( scrollV ).scrollLeft( scrollH );
			}

			this.open(opts);
		},

		onUpdate : function() {
			if (!this.fixed) {
				this.update();
			}
		},

		afterClose: function (opts) {
			// Remove overlay if exists and fancyBox is not opening
			// (e.g., it is not being open using afterClose callback)
			//if (this.overlay && !F.isActive) {
			if (this.overlay && !F.coming) {
				this.overlay.fadeOut(opts.speedOut, $.proxy( this.close, this ));
			}
		}
	};

	/*
	 *	Title helper
	 */

	F.helpers.title = {
		defaults : {
			type     : 'float', // 'float', 'inside', 'outside' or 'over',
			position : 'bottom' // 'top' or 'bottom'
		},

		beforeShow: function (opts) {
			var current = F.current,
				text    = current.title,
				type    = opts.type,
				title,
				target;

			if ($.isFunction(text)) {
				text = text.call(current.element, current);
			}

			if (!isString(text) || $.trim(text) === '') {
				return;
			}

			title = $('<div class="fancybox-title fancybox-title-' + type + '-wrap">' + text + '</div>');

			switch (type) {
				case 'inside':
					target = F.skin;
				break;

				case 'outside':
					target = F.wrap;
				break;

				case 'over':
					target = F.inner;
				break;

				default: // 'float'
					target = F.skin;

					title.appendTo('body');

					if (IE) {
						title.width( title.width() );
					}

					title.wrapInner('<span class="child"></span>');

					//Increase bottom margin so this title will also fit into viewport
					F.current.margin[2] += Math.abs( getScalar(title.css('margin-bottom')) );
				break;
			}

			title[ (opts.position === 'top' ? 'prependTo'  : 'appendTo') ](target);
		}
	};

	// jQuery plugin initialization
	$.fn.fancybox = function (options) {
		var index,
			that     = $(this),
			selector = this.selector || '',
			run      = function(e) {
				var what = $(this).blur(), idx = index, relType, relVal;

				if (!(e.ctrlKey || e.altKey || e.shiftKey || e.metaKey) && !what.is('.fancybox-wrap')) {
					relType = options.groupAttr || 'data-fancybox-group';
					relVal  = what.attr(relType);

					if (!relVal) {
						relType = 'rel';
						relVal  = what.get(0)[ relType ];
					}

					if (relVal && relVal !== '' && relVal !== 'nofollow') {
						what = selector.length ? $(selector) : that;
						what = what.filter('[' + relType + '="' + relVal + '"]');
						idx  = what.index(this);
					}

					options.index = idx;

					// Stop an event from bubbling if everything is fine
					if (F.open(what, options) !== false) {
						e.preventDefault();
					}
				}
			};

		options = options || {};
		index   = options.index || 0;

		if (!selector || options.live === false) {
			that.unbind('click.fb-start').bind('click.fb-start', run);

		} else {
			D.undelegate(selector, 'click.fb-start').delegate(selector + ":not('.fancybox-item, .fancybox-nav')", 'click.fb-start', run);
		}

		this.filter('[data-fancybox-start=1]').trigger('click');

		return this;
	};

	// Tests that need a body at doc ready
	D.ready(function() {
		var w1, w2;

		if ( $.scrollbarWidth === undefined ) {
			// http://benalman.com/projects/jquery-misc-plugins/#scrollbarwidth
			$.scrollbarWidth = function() {
				var parent = $('<div style="width:50px;height:50px;overflow:auto"><div/></div>').appendTo('body'),
					child  = parent.children(),
					width  = child.innerWidth() - child.height( 99 ).innerWidth();

				parent.remove();

				return width;
			};
		}

		if ( $.support.fixedPosition === undefined ) {
			$.support.fixedPosition = (function() {
				var elem  = $('<div style="position:fixed;top:20px;"></div>').appendTo('body'),
					fixed = ( elem[0].offsetTop === 20 || elem[0].offsetTop === 15 );

				elem.remove();

				return fixed;
			}());
		}

		$.extend(F.defaults, {
			scrollbarWidth : $.scrollbarWidth(),
			fixed  : $.support.fixedPosition,
			parent : $('body')
		});

		//Get real width of page scroll-bar
		w1 = $(window).width();

		H.addClass('fancybox-lock-test');

		w2 = $(window).width();

		H.removeClass('fancybox-lock-test');

		$("<style type='text/css'>.fancybox-margin{margin-right:" + (w2 - w1) + "px;}</style>").appendTo("head");
	});

}(window, document, jQuery));;/**
 * Twig.js 0.8.9
 *
 * @copyright 2011-2015 John Roepke and the Twig.js Contributors
 * @license   Available under the BSD 2-Clause License
 * @link      https://github.com/justjohn/twig.js
 */

var Twig = (function (Twig) {

    Twig.VERSION = "0.8.9";

    return Twig;
})(Twig || {});
//     Twig.js
//     Available under the BSD 2-Clause License
//     https://github.com/justjohn/twig.js

var Twig = (function (Twig) {
    "use strict";
    // ## twig.core.js
    //
    // This file handles template level tokenizing, compiling and parsing.

    Twig.trace = false;
    Twig.debug = false;

    // Default caching to true for the improved performance it offers
    Twig.cache = true;

    Twig.placeholders = {
        parent: "{{|PARENT|}}"
    };

    /**
     * Fallback for Array.indexOf for IE8 et al
     */
    Twig.indexOf = function (arr, searchElement /*, fromIndex */ ) {
        if (Array.prototype.hasOwnProperty("indexOf")) {
            return arr.indexOf(searchElement);
        }
        if (arr === void 0 || arr === null) {
            throw new TypeError();
        }
        var t = Object(arr);
        var len = t.length >>> 0;
        if (len === 0) {
            return -1;
        }
        var n = 0;
        if (arguments.length > 0) {
            n = Number(arguments[1]);
            if (n !== n) { // shortcut for verifying if it's NaN
                n = 0;
            } else if (n !== 0 && n !== Infinity && n !== -Infinity) {
                n = (n > 0 || -1) * Math.floor(Math.abs(n));
            }
        }
        if (n >= len) {
            // console.log("indexOf not found1 ", JSON.stringify(searchElement), JSON.stringify(arr));
            return -1;
        }
        var k = n >= 0 ? n : Math.max(len - Math.abs(n), 0);
        for (; k < len; k++) {
            if (k in t && t[k] === searchElement) {
                return k;
            }
        }
        if (arr == searchElement) {
            return 0;
        }
        // console.log("indexOf not found2 ", JSON.stringify(searchElement), JSON.stringify(arr));

        return -1;
    }

    Twig.forEach = function (arr, callback, thisArg) {
        if (Array.prototype.forEach ) {
            return arr.forEach(callback, thisArg);
        }

        var T, k;

        if ( arr == null ) {
          throw new TypeError( " this is null or not defined" );
        }

        // 1. Let O be the result of calling ToObject passing the |this| value as the argument.
        var O = Object(arr);

        // 2. Let lenValue be the result of calling the Get internal method of O with the argument "length".
        // 3. Let len be ToUint32(lenValue).
        var len = O.length >>> 0; // Hack to convert O.length to a UInt32

        // 4. If IsCallable(callback) is false, throw a TypeError exception.
        // See: http://es5.github.com/#x9.11
        if ( {}.toString.call(callback) != "[object Function]" ) {
          throw new TypeError( callback + " is not a function" );
        }

        // 5. If thisArg was supplied, let T be thisArg; else let T be undefined.
        if ( thisArg ) {
          T = thisArg;
        }

        // 6. Let k be 0
        k = 0;

        // 7. Repeat, while k < len
        while( k < len ) {

          var kValue;

          // a. Let Pk be ToString(k).
          //   This is implicit for LHS operands of the in operator
          // b. Let kPresent be the result of calling the HasProperty internal method of O with argument Pk.
          //   This step can be combined with c
          // c. If kPresent is true, then
          if ( k in O ) {

            // i. Let kValue be the result of calling the Get internal method of O with argument Pk.
            kValue = O[ k ];

            // ii. Call the Call internal method of callback with T as the this value and
            // argument list containing kValue, k, and O.
            callback.call( T, kValue, k, O );
          }
          // d. Increase k by 1.
          k++;
        }
        // 8. return undefined
    };

    Twig.merge = function(target, source, onlyChanged) {
        Twig.forEach(Object.keys(source), function (key) {
            if (onlyChanged && !(key in target)) {
                return;
            }

            target[key] = source[key]
        });

        return target;
    };

    /**
     * Exception thrown by twig.js.
     */
    Twig.Error = function(message) {
       this.message = message;
       this.name = "TwigException";
       this.type = "TwigException";
    };

    /**
     * Get the string representation of a Twig error.
     */
    Twig.Error.prototype.toString = function() {
        var output = this.name + ": " + this.message;

        return output;
    };

    /**
     * Wrapper for logging to the console.
     */
    Twig.log = {
        trace: function() {if (Twig.trace && console) {console.log(Array.prototype.slice.call(arguments));}},
        debug: function() {if (Twig.debug && console) {console.log(Array.prototype.slice.call(arguments));}}
    };


    if (typeof console !== "undefined") {
        if (typeof console.error !== "undefined") {
            Twig.log.error = function() {
                console.error.apply(console, arguments);
            }
        } else if (typeof console.log !== "undefined") {
            Twig.log.error = function() {
                console.log.apply(console, arguments);
            }
        }
    } else {
        Twig.log.error = function(){};
    }

    /**
     * Wrapper for child context objects in Twig.
     *
     * @param {Object} context Values to initialize the context with.
     */
    Twig.ChildContext = function(context) {
        var ChildContext = function ChildContext() {};
        ChildContext.prototype = context;
        return new ChildContext();
    };

    /**
     * Container for methods related to handling high level template tokens
     *      (for example: {{ expression }}, {% logic %}, {# comment #}, raw data)
     */
    Twig.token = {};

    /**
     * Token types.
     */
    Twig.token.type = {
        output:                 'output',
        logic:                  'logic',
        comment:                'comment',
        raw:                    'raw',
        output_whitespace_pre:  'output_whitespace_pre',
        output_whitespace_post: 'output_whitespace_post',
        output_whitespace_both: 'output_whitespace_both',
        logic_whitespace_pre:   'logic_whitespace_pre',
        logic_whitespace_post:  'logic_whitespace_post',
        logic_whitespace_both:  'logic_whitespace_both'
    };

    /**
     * Token syntax definitions.
     */
    Twig.token.definitions = [
        {
            type: Twig.token.type.raw,
            open: '{% raw %}',
            close: '{% endraw %}'
        },
        {
            type: Twig.token.type.raw,
            open: '{% verbatim %}',
            close: '{% endverbatim %}'
        },
        // *Whitespace type tokens*
        //
        // These typically take the form `{{- expression -}}` or `{{- expression }}` or `{{ expression -}}`.
        {
            type: Twig.token.type.output_whitespace_pre,
            open: '{{-',
            close: '}}'
        },
        {
            type: Twig.token.type.output_whitespace_post,
            open: '{{',
            close: '-}}'
        },
        {
            type: Twig.token.type.output_whitespace_both,
            open: '{{-',
            close: '-}}'
        },
        {
            type: Twig.token.type.logic_whitespace_pre,
            open: '{%-',
            close: '%}'
        },
        {
            type: Twig.token.type.logic_whitespace_post,
            open: '{%',
            close: '-%}'
        },
        {
            type: Twig.token.type.logic_whitespace_both,
            open: '{%-',
            close: '-%}'
        },
        // *Output type tokens*
        //
        // These typically take the form `{{ expression }}`.
        {
            type: Twig.token.type.output,
            open: '{{',
            close: '}}'
        },
        // *Logic type tokens*
        //
        // These typically take a form like `{% if expression %}` or `{% endif %}`
        {
            type: Twig.token.type.logic,
            open: '{%',
            close: '%}'
        },
        // *Comment type tokens*
        //
        // These take the form `{# anything #}`
        {
            type: Twig.token.type.comment,
            open: '{#',
            close: '#}'
        }
    ];


    /**
     * What characters start "strings" in token definitions. We need this to ignore token close
     * strings inside an expression.
     */
    Twig.token.strings = ['"', "'"];

    Twig.token.findStart = function (template) {
        var output = {
                position: null,
                close_position: null,
                def: null
            },
            i,
            token_template,
            first_key_position,
            close_key_position;

        for (i=0;i<Twig.token.definitions.length;i++) {
            token_template = Twig.token.definitions[i];
            first_key_position = template.indexOf(token_template.open);
            close_key_position = template.indexOf(token_template.close);

            Twig.log.trace("Twig.token.findStart: ", "Searching for ", token_template.open, " found at ", first_key_position);

            //Special handling for mismatched tokens
            if (first_key_position >= 0) {
                //This token matches the template
                if (token_template.open.length !== token_template.close.length) {
                    //This token has mismatched closing and opening tags
                    if (close_key_position < 0) {
                        //This token's closing tag does not match the template
                        continue;
                    }
                }
            }
            // Does this token occur before any other types?
            if (first_key_position >= 0 && (output.position === null || first_key_position < output.position)) {
                output.position = first_key_position;
                output.def = token_template;
                output.close_position = close_key_position;
            } else if (first_key_position >= 0 && output.position !== null && first_key_position === output.position) {
                /*This token exactly matches another token,
                greedily match to check if this token has a greater specificity*/
                if (token_template.open.length > output.def.open.length) {
                    //This token's opening tag is more specific than the previous match
                    output.position = first_key_position;
                    output.def = token_template;
                    output.close_position = close_key_position;
                } else if (token_template.open.length === output.def.open.length) {
                    if (token_template.close.length > output.def.close.length) {
                        //This token's opening tag is as specific as the previous match,
                        //but the closing tag has greater specificity
                        if (close_key_position >= 0 && close_key_position < output.close_position) {
                            //This token's closing tag exists in the template,
                            //and it occurs sooner than the previous match
                            output.position = first_key_position;
                            output.def = token_template;
                            output.close_position = close_key_position;
                        }
                    } else if (close_key_position >= 0 && close_key_position < output.close_position) {
                        //This token's closing tag is not more specific than the previous match,
                        //but it occurs sooner than the previous match
                        output.position = first_key_position;
                        output.def = token_template;
                        output.close_position = close_key_position;
                    }
                }
            }
        }

        delete output['close_position'];

        return output;
    };

    Twig.token.findEnd = function (template, token_def, start) {
        var end = null,
            found = false,
            offset = 0,

            // String position variables
            str_pos = null,
            str_found = null,
            pos = null,
            end_offset = null,
            this_str_pos = null,
            end_str_pos = null,

            // For loop variables
            i,
            l;

        while (!found) {
            str_pos = null;
            str_found = null;
            pos = template.indexOf(token_def.close, offset);

            if (pos >= 0) {
                end = pos;
                found = true;
            } else {
                // throw an exception
                throw new Twig.Error("Unable to find closing bracket '" + token_def.close +
                                "'" + " opened near template position " + start);
            }

            // Ignore quotes within comments; just look for the next comment close sequence,
            // regardless of what comes before it. https://github.com/justjohn/twig.js/issues/95
            if (token_def.type === Twig.token.type.comment) {
              break;
            }
            // Ignore quotes within raw tag
            // Fixes #283
            if (token_def.type === Twig.token.type.raw) {
                break;
            }

            l = Twig.token.strings.length;
            for (i = 0; i < l; i += 1) {
                this_str_pos = template.indexOf(Twig.token.strings[i], offset);

                if (this_str_pos > 0 && this_str_pos < pos &&
                        (str_pos === null || this_str_pos < str_pos)) {
                    str_pos = this_str_pos;
                    str_found = Twig.token.strings[i];
                }
            }

            // We found a string before the end of the token, now find the string's end and set the search offset to it
            if (str_pos !== null) {
                end_offset = str_pos + 1;
                end = null;
                found = false;
                while (true) {
                    end_str_pos = template.indexOf(str_found, end_offset);
                    if (end_str_pos < 0) {
                        throw "Unclosed string in template";
                    }
                    // Ignore escaped quotes
                    if (template.substr(end_str_pos - 1, 1) !== "\\") {
                        offset = end_str_pos + 1;
                        break;
                    } else {
                        end_offset = end_str_pos + 1;
                    }
                }
            }
        }
        return end;
    };

    /**
     * Convert a template into high-level tokens.
     */
    Twig.tokenize = function (template) {
        var tokens = [],
            // An offset for reporting errors locations in the template.
            error_offset = 0,

            // The start and type of the first token found in the template.
            found_token = null,
            // The end position of the matched token.
            end = null;

        while (template.length > 0) {
            // Find the first occurance of any token type in the template
            found_token = Twig.token.findStart(template);

            Twig.log.trace("Twig.tokenize: ", "Found token: ", found_token);

            if (found_token.position !== null) {
                // Add a raw type token for anything before the start of the token
                if (found_token.position > 0) {
                    tokens.push({
                        type: Twig.token.type.raw,
                        value: template.substring(0, found_token.position)
                    });
                }
                template = template.substr(found_token.position + found_token.def.open.length);
                error_offset += found_token.position + found_token.def.open.length;

                // Find the end of the token
                end = Twig.token.findEnd(template, found_token.def, error_offset);

                Twig.log.trace("Twig.tokenize: ", "Token ends at ", end);

                tokens.push({
                    type:  found_token.def.type,
                    value: template.substring(0, end).trim()
                });

                if (template.substr( end + found_token.def.close.length, 1 ) === "\n") {
                    switch (found_token.def.type) {
                        case "logic_whitespace_pre":
                        case "logic_whitespace_post":
                        case "logic_whitespace_both":
                        case "logic":
                            // Newlines directly after logic tokens are ignored
                            end += 1;
                            break;
                    }
                }

                template = template.substr(end + found_token.def.close.length);

                // Increment the position in the template
                error_offset += end + found_token.def.close.length;

            } else {
                // No more tokens -> add the rest of the template as a raw-type token
                tokens.push({
                    type: Twig.token.type.raw,
                    value: template
                });
                template = '';
            }
        }

        return tokens;
    };


    Twig.compile = function (tokens) {
        try {

            // Output and intermediate stacks
            var output = [],
                stack = [],
                // The tokens between open and close tags
                intermediate_output = [],

                token = null,
                logic_token = null,
                unclosed_token = null,
                // Temporary previous token.
                prev_token = null,
                // Temporary previous output.
                prev_output = null,
                // Temporary previous intermediate output.
                prev_intermediate_output = null,
                // The previous token's template
                prev_template = null,
                // Token lookahead
                next_token = null,
                // The output token
                tok_output = null,

                // Logic Token values
                type = null,
                open = null,
                next = null;

            var compile_output = function(token) {
                Twig.expression.compile.apply(this, [token]);
                if (stack.length > 0) {
                    intermediate_output.push(token);
                } else {
                    output.push(token);
                }
            };

            var compile_logic = function(token) {
                // Compile the logic token
                logic_token = Twig.logic.compile.apply(this, [token]);

                type = logic_token.type;
                open = Twig.logic.handler[type].open;
                next = Twig.logic.handler[type].next;

                Twig.log.trace("Twig.compile: ", "Compiled logic token to ", logic_token,
                                                 " next is: ", next, " open is : ", open);

                // Not a standalone token, check logic stack to see if this is expected
                if (open !== undefined && !open) {
                    prev_token = stack.pop();
                    prev_template = Twig.logic.handler[prev_token.type];

                    if (Twig.indexOf(prev_template.next, type) < 0) {
                        throw new Error(type + " not expected after a " + prev_token.type);
                    }

                    prev_token.output = prev_token.output || [];

                    prev_token.output = prev_token.output.concat(intermediate_output);
                    intermediate_output = [];

                    tok_output = {
                        type: Twig.token.type.logic,
                        token: prev_token
                    };
                    if (stack.length > 0) {
                        intermediate_output.push(tok_output);
                    } else {
                        output.push(tok_output);
                    }
                }

                // This token requires additional tokens to complete the logic structure.
                if (next !== undefined && next.length > 0) {
                    Twig.log.trace("Twig.compile: ", "Pushing ", logic_token, " to logic stack.");

                    if (stack.length > 0) {
                        // Put any currently held output into the output list of the logic operator
                        // currently at the head of the stack before we push a new one on.
                        prev_token = stack.pop();
                        prev_token.output = prev_token.output || [];
                        prev_token.output = prev_token.output.concat(intermediate_output);
                        stack.push(prev_token);
                        intermediate_output = [];
                    }

                    // Push the new logic token onto the logic stack
                    stack.push(logic_token);

                } else if (open !== undefined && open) {
                    tok_output = {
                        type: Twig.token.type.logic,
                        token: logic_token
                    };
                    // Standalone token (like {% set ... %}
                    if (stack.length > 0) {
                        intermediate_output.push(tok_output);
                    } else {
                        output.push(tok_output);
                    }
                }
            };

            while (tokens.length > 0) {
                token = tokens.shift();
                prev_output = output[output.length - 1];
                prev_intermediate_output = intermediate_output[intermediate_output.length - 1];
                next_token = tokens[0];
                Twig.log.trace("Compiling token ", token);
                switch (token.type) {
                    case Twig.token.type.raw:
                        if (stack.length > 0) {
                            intermediate_output.push(token);
                        } else {
                            output.push(token);
                        }
                        break;

                    case Twig.token.type.logic:
                        compile_logic.call(this, token);
                        break;

                    // Do nothing, comments should be ignored
                    case Twig.token.type.comment:
                        break;

                    case Twig.token.type.output:
                        compile_output.call(this, token);
                        break;

                    //Kill whitespace ahead and behind this token
                    case Twig.token.type.logic_whitespace_pre:
                    case Twig.token.type.logic_whitespace_post:
                    case Twig.token.type.logic_whitespace_both:
                    case Twig.token.type.output_whitespace_pre:
                    case Twig.token.type.output_whitespace_post:
                    case Twig.token.type.output_whitespace_both:
                        if (token.type !== Twig.token.type.output_whitespace_post && token.type !== Twig.token.type.logic_whitespace_post) {
                            if (prev_output) {
                                //If the previous output is raw, pop it off
                                if (prev_output.type === Twig.token.type.raw) {
                                    output.pop();

                                    //If the previous output is not just whitespace, trim it
                                    if (prev_output.value.match(/^\s*$/) === null) {
                                        prev_output.value = prev_output.value.trim();
                                        //Repush the previous output
                                        output.push(prev_output);
                                    }
                                }
                            }

                            if (prev_intermediate_output) {
                                //If the previous intermediate output is raw, pop it off
                                if (prev_intermediate_output.type === Twig.token.type.raw) {
                                    intermediate_output.pop();

                                    //If the previous output is not just whitespace, trim it
                                    if (prev_intermediate_output.value.match(/^\s*$/) === null) {
                                        prev_intermediate_output.value = prev_intermediate_output.value.trim();
                                        //Repush the previous intermediate output
                                        intermediate_output.push(prev_intermediate_output);
                                    }
                                }
                            }
                        }

                        //Compile this token
                        switch (token.type) {
                            case Twig.token.type.output_whitespace_pre:
                            case Twig.token.type.output_whitespace_post:
                            case Twig.token.type.output_whitespace_both:
                                compile_output.call(this, token);
                                break;
                            case Twig.token.type.logic_whitespace_pre:
                            case Twig.token.type.logic_whitespace_post:
                            case Twig.token.type.logic_whitespace_both:
                                compile_logic.call(this, token);
                                break;
                        }

                        if (token.type !== Twig.token.type.output_whitespace_pre && token.type !== Twig.token.type.logic_whitespace_pre) {
                            if (next_token) {
                                //If the next token is raw, shift it out
                                if (next_token.type === Twig.token.type.raw) {
                                    tokens.shift();

                                    //If the next token is not just whitespace, trim it
                                    if (next_token.value.match(/^\s*$/) === null) {
                                        next_token.value = next_token.value.trim();
                                        //Unshift the next token
                                        tokens.unshift(next_token);
                                    }
                                }
                            }
                        }

                        break;
                }

                Twig.log.trace("Twig.compile: ", " Output: ", output,
                                                 " Logic Stack: ", stack,
                                                 " Pending Output: ", intermediate_output );
            }

            // Verify that there are no logic tokens left in the stack.
            if (stack.length > 0) {
                unclosed_token = stack.pop();
                throw new Error("Unable to find an end tag for " + unclosed_token.type +
                                ", expecting one of " + unclosed_token.next);
            }
            return output;
        } catch (ex) {
            Twig.log.error("Error compiling twig template " + this.id + ": ");
            if (ex.stack) {
                Twig.log.error(ex.stack);
            } else {
                Twig.log.error(ex.toString());
            }

            if (this.options.rethrow) throw ex;
        }
    };

    /**
     * Parse a compiled template.
     *
     * @param {Array} tokens The compiled tokens.
     * @param {Object} context The render context.
     *
     * @return {string} The parsed template.
     */
    Twig.parse = function (tokens, context) {
        try {
            var output = [],
                // Track logic chains
                chain = true,
                that = this;

            Twig.forEach(tokens, function parseToken(token) {
                Twig.log.debug("Twig.parse: ", "Parsing token: ", token);

                switch (token.type) {
                    case Twig.token.type.raw:
                        output.push(Twig.filters.raw(token.value));
                        break;

                    case Twig.token.type.logic:
                        var logic_token = token.token,
                            logic = Twig.logic.parse.apply(that, [logic_token, context, chain]);

                        if (logic.chain !== undefined) {
                            chain = logic.chain;
                        }
                        if (logic.context !== undefined) {
                            context = logic.context;
                        }
                        if (logic.output !== undefined) {
                            output.push(logic.output);
                        }
                        break;

                    case Twig.token.type.comment:
                        // Do nothing, comments should be ignored
                        break;

                    //Fall through whitespace to output
                    case Twig.token.type.output_whitespace_pre:
                    case Twig.token.type.output_whitespace_post:
                    case Twig.token.type.output_whitespace_both:
                    case Twig.token.type.output:
                        Twig.log.debug("Twig.parse: ", "Output token: ", token.stack);
                        // Parse the given expression in the given context
                        output.push(Twig.expression.parse.apply(that, [token.stack, context]));
                        break;
                }
            });
            return Twig.output.apply(this, [output]);
        } catch (ex) {
            Twig.log.error("Error parsing twig template " + this.id + ": ");
            if (ex.stack) {
                Twig.log.error(ex.stack);
            } else {
                Twig.log.error(ex.toString());
            }

            if (this.options.rethrow) throw ex;

            if (Twig.debug) {
                return ex.toString();
            }
        }
    };

    /**
     * Tokenize and compile a string template.
     *
     * @param {string} data The template.
     *
     * @return {Array} The compiled tokens.
     */
    Twig.prepare = function(data) {
        var tokens, raw_tokens;

        // Tokenize
        Twig.log.debug("Twig.prepare: ", "Tokenizing ", data);
        raw_tokens = Twig.tokenize.apply(this, [data]);

        // Compile
        Twig.log.debug("Twig.prepare: ", "Compiling ", raw_tokens);
        tokens = Twig.compile.apply(this, [raw_tokens]);

        Twig.log.debug("Twig.prepare: ", "Compiled ", tokens);

        return tokens;
    };

    /**
     * Join the output token's stack and escape it if needed
     *
     * @param {Array} Output token's stack
     *
     * @return {string|String} Autoescaped output
     */
    Twig.output = function(output) {
        if (!this.options.autoescape) {
            return output.join("");
        }

        var strategy = 'html';
        if(typeof this.options.autoescape == 'string')
            strategy = this.options.autoescape;

        // [].map would be better but it's not supported by IE8-
        var escaped_output = [];
        Twig.forEach(output, function (str) {
            if (str && (str.twig_markup !== true && str.twig_markup != strategy)) {
                str = Twig.filters.escape(str, [ strategy ]);
            }
            escaped_output.push(str);
        });
        return Twig.Markup(escaped_output.join(""));
    }

    // Namespace for template storage and retrieval
    Twig.Templates = {
        /**
         * Registered template loaders - use Twig.Templates.registerLoader to add supported loaders
         * @type {Object}
         */
        loaders: {},

        /**
         * Registered template parsers - use Twig.Templates.registerParser to add supported parsers
         * @type {Object}
         */
        parsers: {},

        /**
         * Cached / loaded templates
         * @type {Object}
         */
        registry: {}
    };

    /**
     * Is this id valid for a twig template?
     *
     * @param {string} id The ID to check.
     *
     * @throws {Twig.Error} If the ID is invalid or used.
     * @return {boolean} True if the ID is valid.
     */
    Twig.validateId = function(id) {
        if (id === "prototype") {
            throw new Twig.Error(id + " is not a valid twig identifier");
        } else if (Twig.cache && Twig.Templates.registry.hasOwnProperty(id)) {
            throw new Twig.Error("There is already a template with the ID " + id);
        }
        return true;
    }

    /**
     * Register a template loader
     *
     * @example
     * Twig.extend(function(Twig) {
     *    Twig.Templates.registerLoader('custom_loader', function(location, params, callback, error_callback) {
     *        // ... load the template ...
     *        params.data = loadedTemplateData;
     *        // create and return the template
     *        var template = new Twig.Template(params);
     *        if (typeof callback === 'function') {
     *            callback(template);
     *        }
     *        return template;
     *    });
     * });
     * 
     * @param {String} method_name The method this loader is intended for (ajax, fs)
     * @param {Function} func The function to execute when loading the template
     * @param {Object|undefined} scope Optional scope parameter to bind func to
     *
     * @throws Twig.Error
     *
     * @return {void}
     */
    Twig.Templates.registerLoader = function(method_name, func, scope) {
        if (typeof func !== 'function') {
            throw new Twig.Error('Unable to add loader for ' + method_name + ': Invalid function reference given.');
        }
        if (scope) {
            func = func.bind(scope);
        }
        this.loaders[method_name] = func;
    };

    /**
     * Remove a registered loader
     * 
     * @param {String} method_name The method name for the loader you wish to remove
     *
     * @return {void}
     */
    Twig.Templates.unRegisterLoader = function(method_name) {
        if (this.isRegisteredLoader(method_name)) {
            delete this.loaders[method_name];
        }
    };

    /**
     * See if a loader is registered by its method name
     * 
     * @param {String} method_name The name of the loader you are looking for
     *
     * @return {boolean}
     */
    Twig.Templates.isRegisteredLoader = function(method_name) {
        return this.loaders.hasOwnProperty(method_name);
    };

    /**
     * Register a template parser
     *
     * @example
     * Twig.extend(function(Twig) {
     *    Twig.Templates.registerParser('custom_parser', function(params) {
     *        // this template source can be accessed in params.data
     *        var template = params.data
     *
     *        // ... custom process that modifies the template
     *
     *        // return the parsed template
     *        return template;
     *    });
     * });
     *
     * @param {String} method_name The method this parser is intended for (twig, source)
     * @param {Function} func The function to execute when parsing the template
     * @param {Object|undefined} scope Optional scope parameter to bind func to
     *
     * @throws Twig.Error
     *
     * @return {void}
     */
    Twig.Templates.registerParser = function(method_name, func, scope) {
        if (typeof func !== 'function') {
            throw new Twig.Error('Unable to add parser for ' + method_name + ': Invalid function regerence given.');
        }

        if (scope) {
            func = func.bind(scope);
        }

        this.parsers[method_name] = func;
    };

    /**
     * Remove a registered parser
     *
     * @param {String} method_name The method name for the parser you wish to remove
     *
     * @return {void}
     */
    Twig.Templates.unRegisterParser = function(method_name) {
        if (this.isRegisteredParser(method_name)) {
            delete this.parsers[method_name];
        }
    };

    /**
     * See if a parser is registered by its method name
     *
     * @param {String} method_name The name of the parser you are looking for
     *
     * @return {boolean}
     */
    Twig.Templates.isRegisteredParser = function(method_name) {
        return this.parsers.hasOwnProperty(method_name);
    };

    /**
     * Save a template object to the store.
     *
     * @param {Twig.Template} template   The twig.js template to store.
     */
    Twig.Templates.save = function(template) {
        if (template.id === undefined) {
            throw new Twig.Error("Unable to save template with no id");
        }
        Twig.Templates.registry[template.id] = template;
    };

    /**
     * Load a previously saved template from the store.
     *
     * @param {string} id   The ID of the template to load.
     *
     * @return {Twig.Template} A twig.js template stored with the provided ID.
     */
    Twig.Templates.load = function(id) {
        if (!Twig.Templates.registry.hasOwnProperty(id)) {
            return null;
        }
        return Twig.Templates.registry[id];
    };

    /**
     * Load a template from a remote location using AJAX and saves in with the given ID.
     *
     * Available parameters:
     *
     *      async:       Should the HTTP request be performed asynchronously.
     *                      Defaults to true.
     *      method:      What method should be used to load the template
     *                      (fs or ajax)
     *      parser:      What method should be used to parse the template
     *                      (twig or source)
     *      precompiled: Has the template already been compiled.
     *
     * @param {string} location  The remote URL to load as a template.
     * @param {Object} params The template parameters.
     * @param {function} callback  A callback triggered when the template finishes loading.
     * @param {function} error_callback  A callback triggered if an error occurs loading the template.
     *
     *
     */
    Twig.Templates.loadRemote = function(location, params, callback, error_callback) {
        var loader;

        // Default to async
        if (params.async === undefined) {
            params.async = true;
        }

        // Default to the URL so the template is cached.
        if (params.id === undefined) {
            params.id = location;
        }

        // Check for existing template
        if (Twig.cache && Twig.Templates.registry.hasOwnProperty(params.id)) {
            // A template is already saved with the given id.
            if (typeof callback === 'function') {
                callback(Twig.Templates.registry[params.id]);
            }
            // TODO: if async, return deferred promise
            return Twig.Templates.registry[params.id];
        }

        //if the parser name hasn't been set, default it to twig
        params.parser = params.parser || 'twig';

        // Assume 'fs' if the loader is not defined
        loader = this.loaders[params.method] || this.loaders.fs;
        return loader.apply(this, arguments);
    };

    // Determine object type
    function is(type, obj) {
        var clas = Object.prototype.toString.call(obj).slice(8, -1);
        return obj !== undefined && obj !== null && clas === type;
    }

    /**
     * Create a new twig.js template.
     *
     * Parameters: {
     *      data:   The template, either pre-compiled tokens or a string template
     *      id:     The name of this template
     *      blocks: Any pre-existing block from a child template
     * }
     *
     * @param {Object} params The template parameters.
     */
    Twig.Template = function ( params ) {
        var data = params.data,
            id = params.id,
            blocks = params.blocks,
            macros = params.macros || {},
            base = params.base,
            path = params.path,
            url = params.url,
            name = params.name,
            method = params.method,
            // parser options
            options = params.options;

        // # What is stored in a Twig.Template
        //
        // The Twig Template hold several chucks of data.
        //
        //     {
        //          id:     The token ID (if any)
        //          tokens: The list of tokens that makes up this template.
        //          blocks: The list of block this template contains.
        //          base:   The base template (if any)
        //            options:  {
        //                Compiler/parser options
        //
        //                strict_variables: true/false
        //                    Should missing variable/keys emit an error message. If false, they default to null.
        //            }
        //     }
        //

        this.id     = id;
        this.method = method;
        this.base   = base;
        this.path   = path;
        this.url    = url;
        this.name   = name;
        this.macros = macros;
        this.options = options;

        this.reset(blocks);

        if (is('String', data)) {
            this.tokens = Twig.prepare.apply(this, [data]);
        } else {
            this.tokens = data;
        }

        if (id !== undefined) {
            Twig.Templates.save(this);
        }
    };

    Twig.Template.prototype.reset = function(blocks) {
        Twig.log.debug("Twig.Template.reset", "Reseting template " + this.id);
        this.blocks = {};
        this.importedBlocks = [];
        this.originalBlockTokens = {};
        this.child = {
            blocks: blocks || {}
        };
        this.extend = null;
    };

    Twig.Template.prototype.render = function (context, params) {
        params = params || {};

        var output,
            url;

        this.context = context || {};

        // Clear any previous state
        this.reset();
        if (params.blocks) {
            this.blocks = params.blocks;
        }
        if (params.macros) {
            this.macros = params.macros;
        }

        output = Twig.parse.apply(this, [this.tokens, this.context]);

        // Does this template extend another
        if (this.extend) {
            var ext_template;

            // check if the template is provided inline
            if ( this.options.allowInlineIncludes ) {
                ext_template = Twig.Templates.load(this.extend);
                if ( ext_template ) {
                    ext_template.options = this.options;
                }
            }

            // check for the template file via include
            if (!ext_template) {
                url = Twig.path.parsePath(this, this.extend);

                ext_template = Twig.Templates.loadRemote(url, {
                    method: this.getLoaderMethod(),
                    base: this.base,
                    async:  false,
                    id:     url,
                    options: this.options
                });
            }

            this.parent = ext_template;

            return this.parent.render(this.context, {
                blocks: this.blocks
            });
        }

        if (params.output == 'blocks') {
            return this.blocks;
        } else if (params.output == 'macros') {
            return this.macros;
        } else {
            return output;
        }
    };

    Twig.Template.prototype.importFile = function(file) {
        var url, sub_template;
        if (!this.url && this.options.allowInlineIncludes) {
            file = this.path ? this.path + '/' + file : file;
            sub_template = Twig.Templates.load(file);

            if (!sub_template) {
                sub_template = Twig.Templates.loadRemote(url, {
                    id: file,
                    method: this.getLoaderMethod(),
                    async: false,
                    options: this.options
                });

                if (!sub_template) {
                    throw new Twig.Error("Unable to find the template " + file);
                }
            }

            sub_template.options = this.options;

            return sub_template;
        }

        url = Twig.path.parsePath(this, file);

        // Load blocks from an external file
        sub_template = Twig.Templates.loadRemote(url, {
            method: this.getLoaderMethod(),
            base: this.base,
            async: false,
            options: this.options,
            id: url
        });

        return sub_template;
    };

    Twig.Template.prototype.importBlocks = function(file, override) {
        var sub_template = this.importFile(file),
            context = this.context,
            that = this,
            key;

        override = override || false;

        sub_template.render(context);

        // Mixin blocks
        Twig.forEach(Object.keys(sub_template.blocks), function(key) {
            if (override || that.blocks[key] === undefined) {
                that.blocks[key] = sub_template.blocks[key];
                that.importedBlocks.push(key);
            }
        });
    };

    Twig.Template.prototype.importMacros = function(file) {
        var url = Twig.path.parsePath(this, file);

        // load remote template
        var remoteTemplate = Twig.Templates.loadRemote(url, {
            method: this.getLoaderMethod(),
            async: false,
            id: url
        });

        return remoteTemplate;
    };

    Twig.Template.prototype.getLoaderMethod = function() {
        if (this.path) {
            return 'fs';
        }
        if (this.url) {
            return 'ajax';
        }
        return this.method || 'fs';
    };

    Twig.Template.prototype.compile = function(options) {
        // compile the template into raw JS
        return Twig.compiler.compile(this, options);
    };

    /**
     * Create safe output
     *
     * @param {string} Content safe to output
     *
     * @return {String} Content wrapped into a String
     */

    Twig.Markup = function(content, strategy) {
        if(typeof strategy == 'undefined') {
            strategy = true;
        }

        if (typeof content === 'string' && content.length > 0) {
            content = new String(content);
            content.twig_markup = strategy;
        }
        return content;
    };

    return Twig;

}) (Twig || { });

(function(Twig) {

    'use strict';

    Twig.Templates.registerLoader('ajax', function(location, params, callback, error_callback) {
        var template,
            xmlhttp,
            precompiled = params.precompiled,
            parser = this.parsers[params.parser] || this.parser.twig;

        if (typeof XMLHttpRequest === "undefined") {
            throw new Twig.Error('Unsupported platform: Unable to do ajax requests ' +
                                 'because there is no "XMLHTTPRequest" implementation');
        }

        xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            var data = null;

            if(xmlhttp.readyState === 4) {
                if (xmlhttp.status === 200 || (window.cordova && xmlhttp.status == 0)) {
                    Twig.log.debug("Got template ", xmlhttp.responseText);

                    if (precompiled === true) {
                        data = JSON.parse(xmlhttp.responseText);
                    } else {
                        data = xmlhttp.responseText;
                    }

                    params.url = location;
                    params.data = data;

                    template = parser.call(this, params);

                    if (typeof callback === 'function') {
                        callback(template);
                    }
                } else {
                    if (typeof error_callback === 'function') {
                        error_callback(xmlhttp);
                    }
                }
            }
        };
        xmlhttp.open("GET", location, !!params.async);
        xmlhttp.send();

        if (params.async) {
            // TODO: return deferred promise
            return true;
        } else {
            return template;
        }
    });

}(Twig));(function(Twig) {
    'use strict';

    var fs, path;

    try {
    	// require lib dependencies at runtime
    	fs = require('fs');
    	path = require('path');
    } catch (e) {
    	// NOTE: this is in a try/catch to avoid errors cross platform
    }

    Twig.Templates.registerLoader('fs', function(location, params, callback, error_callback) {
        var template,
            data = null,
            precompiled = params.precompiled,
            parser = this.parsers[params.parser] || this.parser.twig;

        if (!fs || !path) {
            throw new Twig.Error('Unsupported platform: Unable to load from file ' +
                                 'because there is no "fs" or "path" implementation');
        }

        var loadTemplateFn = function(err, data) {
            if (err) {
                if (typeof error_callback === 'function') {
                    error_callback(err);
                }
                return;
            }

            if (precompiled === true) {
                data = JSON.parse(data);
            }

            params.data = data;
            params.path = params.path || location;

            // template is in data
            template = parser.call(this, params);

            if (typeof callback === 'function') {
                callback(template);
            }
        };
        params.path = params.path || location;

        if (params.async) {
            fs.stat(params.path, function (err, stats) {
                if (err || !stats.isFile()) {
                    throw new Twig.Error('Unable to find template file ' + location);
                }
                fs.readFile(params.path, 'utf8', loadTemplateFn);
            });
            // TODO: return deferred promise
            return true;
        } else {
            if (!fs.statSync(params.path).isFile()) {
                throw new Twig.Error('Unable to find template file ' + location);
            }
            data = fs.readFileSync(params.path, 'utf8');
            loadTemplateFn(undefined, data);
            return template
        }
    });

}(Twig));(function(Twig){
    'use strict';

    Twig.Templates.registerParser('source', function(params) {
        return params.data || '';
    });
})(Twig);
(function(Twig){
    'use strict';

    Twig.Templates.registerParser('twig', function(params) {
        return new Twig.Template(params);
    });
})(Twig);
// The following methods are from MDN and are available under a
// [MIT License](http://www.opensource.org/licenses/mit-license.php) or are
// [Public Domain](https://developer.mozilla.org/Project:Copyrights).
//
// See:
// * [Object.keys - MDN](https://developer.mozilla.org/en/JavaScript/Reference/Global_Objects/Object/keys)

// ## twig.fills.js
//
// This file contains fills for backwards compatability.
(function() {
    "use strict";
    // Handle methods that don't yet exist in every browser

    if (!String.prototype.trim) {
        String.prototype.trim = function() {
            return this.replace(/^\s+|\s+$/g,'');
        }
    };

    if(!Object.keys) Object.keys = function(o){
        if (o !== Object(o)) {
            throw new TypeError('Object.keys called on non-object');
        }
        var ret = [], p;
        for (p in o) if (Object.prototype.hasOwnProperty.call(o, p)) ret.push(p);
        return ret;
    }

})();
// ## twig.lib.js
//
// This file contains 3rd party libraries used within twig.
//
// Copies of the licenses for the code included here can be found in the
// LICENSES.md file.
//

var Twig = (function(Twig) {

    // Namespace for libraries
    Twig.lib = { };

    /**
    sprintf() for JavaScript 1.0.3
    https://github.com/alexei/sprintf.js
    **/
    var sprintfLib = (function() {
        var re = {
            not_string: /[^s]/,
            number: /[diefg]/,
            json: /[j]/,
            not_json: /[^j]/,
            text: /^[^\x25]+/,
            modulo: /^\x25{2}/,
            placeholder: /^\x25(?:([1-9]\d*)\$|\(([^\)]+)\))?(\+)?(0|'[^$])?(-)?(\d+)?(?:\.(\d+))?([b-gijosuxX])/,
            key: /^([a-z_][a-z_\d]*)/i,
            key_access: /^\.([a-z_][a-z_\d]*)/i,
            index_access: /^\[(\d+)\]/,
            sign: /^[\+\-]/
        }

        function sprintf() {
            var key = arguments[0], cache = sprintf.cache
            if (!(cache[key] && cache.hasOwnProperty(key))) {
                cache[key] = sprintf.parse(key)
            }
            return sprintf.format.call(null, cache[key], arguments)
        }

        sprintf.format = function(parse_tree, argv) {
            var cursor = 1, tree_length = parse_tree.length, node_type = "", arg, output = [], i, k, match, pad, pad_character, pad_length, is_positive = true, sign = ""
            for (i = 0; i < tree_length; i++) {
                node_type = get_type(parse_tree[i])
                if (node_type === "string") {
                    output[output.length] = parse_tree[i]
                }
                else if (node_type === "array") {
                    match = parse_tree[i] // convenience purposes only
                    if (match[2]) { // keyword argument
                        arg = argv[cursor]
                        for (k = 0; k < match[2].length; k++) {
                            if (!arg.hasOwnProperty(match[2][k])) {
                                throw new Error(sprintf("[sprintf] property '%s' does not exist", match[2][k]))
                            }
                            arg = arg[match[2][k]]
                        }
                    }
                    else if (match[1]) { // positional argument (explicit)
                        arg = argv[match[1]]
                    }
                    else { // positional argument (implicit)
                        arg = argv[cursor++]
                    }

                    if (get_type(arg) == "function") {
                        arg = arg()
                    }

                    if (re.not_string.test(match[8]) && re.not_json.test(match[8]) && (get_type(arg) != "number" && isNaN(arg))) {
                        throw new TypeError(sprintf("[sprintf] expecting number but found %s", get_type(arg)))
                    }

                    if (re.number.test(match[8])) {
                        is_positive = arg >= 0
                    }

                    switch (match[8]) {
                        case "b":
                            arg = arg.toString(2)
                            break
                        case "c":
                            arg = String.fromCharCode(arg)
                            break
                        case "d":
                        case "i":
                            arg = parseInt(arg, 10)
                            break
                        case "j":
                            arg = JSON.stringify(arg, null, match[6] ? parseInt(match[6]) : 0)
                            break
                        case "e":
                            arg = match[7] ? arg.toExponential(match[7]) : arg.toExponential()
                            break
                        case "f":
                            arg = match[7] ? parseFloat(arg).toFixed(match[7]) : parseFloat(arg)
                            break
                        case "g":
                            arg = match[7] ? parseFloat(arg).toPrecision(match[7]) : parseFloat(arg)
                            break
                        case "o":
                            arg = arg.toString(8)
                            break
                        case "s":
                            arg = ((arg = String(arg)) && match[7] ? arg.substring(0, match[7]) : arg)
                            break
                        case "u":
                            arg = arg >>> 0
                            break
                        case "x":
                            arg = arg.toString(16)
                            break
                        case "X":
                            arg = arg.toString(16).toUpperCase()
                            break
                    }
                    if (re.json.test(match[8])) {
                        output[output.length] = arg
                    }
                    else {
                        if (re.number.test(match[8]) && (!is_positive || match[3])) {
                            sign = is_positive ? "+" : "-"
                            arg = arg.toString().replace(re.sign, "")
                        }
                        else {
                            sign = ""
                        }
                        pad_character = match[4] ? match[4] === "0" ? "0" : match[4].charAt(1) : " "
                        pad_length = match[6] - (sign + arg).length
                        pad = match[6] ? (pad_length > 0 ? str_repeat(pad_character, pad_length) : "") : ""
                        output[output.length] = match[5] ? sign + arg + pad : (pad_character === "0" ? sign + pad + arg : pad + sign + arg)
                    }
                }
            }
            return output.join("")
        }

        sprintf.cache = {}

        sprintf.parse = function(fmt) {
            var _fmt = fmt, match = [], parse_tree = [], arg_names = 0
            while (_fmt) {
                if ((match = re.text.exec(_fmt)) !== null) {
                    parse_tree[parse_tree.length] = match[0]
                }
                else if ((match = re.modulo.exec(_fmt)) !== null) {
                    parse_tree[parse_tree.length] = "%"
                }
                else if ((match = re.placeholder.exec(_fmt)) !== null) {
                    if (match[2]) {
                        arg_names |= 1
                        var field_list = [], replacement_field = match[2], field_match = []
                        if ((field_match = re.key.exec(replacement_field)) !== null) {
                            field_list[field_list.length] = field_match[1]
                            while ((replacement_field = replacement_field.substring(field_match[0].length)) !== "") {
                                if ((field_match = re.key_access.exec(replacement_field)) !== null) {
                                    field_list[field_list.length] = field_match[1]
                                }
                                else if ((field_match = re.index_access.exec(replacement_field)) !== null) {
                                    field_list[field_list.length] = field_match[1]
                                }
                                else {
                                    throw new SyntaxError("[sprintf] failed to parse named argument key")
                                }
                            }
                        }
                        else {
                            throw new SyntaxError("[sprintf] failed to parse named argument key")
                        }
                        match[2] = field_list
                    }
                    else {
                        arg_names |= 2
                    }
                    if (arg_names === 3) {
                        throw new Error("[sprintf] mixing positional and named placeholders is not (yet) supported")
                    }
                    parse_tree[parse_tree.length] = match
                }
                else {
                    throw new SyntaxError("[sprintf] unexpected placeholder")
                }
                _fmt = _fmt.substring(match[0].length)
            }
            return parse_tree
        }

        var vsprintf = function(fmt, argv, _argv) {
            _argv = (argv || []).slice(0)
            _argv.splice(0, 0, fmt)
            return sprintf.apply(null, _argv)
        }

        /**
         * helpers
         */
        function get_type(variable) {
            return Object.prototype.toString.call(variable).slice(8, -1).toLowerCase()
        }

        function str_repeat(input, multiplier) {
            return Array(multiplier + 1).join(input)
        }

        /**
         * export
         */
        return {
            sprintf: sprintf,
            vsprintf: vsprintf
        }
    })();

    var sprintf = sprintfLib.sprintf;
    var vsprintf = sprintfLib.vsprintf;

    // Expose to Twig
    Twig.lib.sprintf = sprintf;
    Twig.lib.vsprintf = vsprintf;


    /**
     * jPaq - A fully customizable JavaScript/JScript library
     * http://jpaq.org/
     *
     * Copyright (c) 2011 Christopher West
     * Licensed under the MIT license.
     * http://jpaq.org/license/
     *
     * Version: 1.0.6.0000W
     * Revised: April 6, 2011
     */
    ; (function() {
        var shortDays = "Sun,Mon,Tue,Wed,Thu,Fri,Sat".split(",");
        var fullDays = "Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday".split(",");
        var shortMonths = "Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep,Oct,Nov,Dec".split(",");
        var fullMonths = "January,February,March,April,May,June,July,August,September,October,November,December".split(",");
        function getOrdinalFor(intNum) {
                return (((intNum = Math.abs(intNum) % 100) % 10 == 1 && intNum != 11) ? "st"
                        : (intNum % 10 == 2 && intNum != 12) ? "nd" : (intNum % 10 == 3
                        && intNum != 13) ? "rd" : "th");
        }
        function getISO8601Year(aDate) {
                var d = new Date(aDate.getFullYear() + 1, 0, 4);
                if((d - aDate) / 86400000 < 7 && (aDate.getDay() + 6) % 7 < (d.getDay() + 6) % 7)
                        return d.getFullYear();
                if(aDate.getMonth() > 0 || aDate.getDate() >= 4)
                        return aDate.getFullYear();
                return aDate.getFullYear() - (((aDate.getDay() + 6) % 7 - aDate.getDate() > 2) ? 1 : 0);
        }
        function getISO8601Week(aDate) {
                // Get a day during the first week of the year.
                var d = new Date(getISO8601Year(aDate), 0, 4);
                // Get the first monday of the year.
                d.setDate(d.getDate() - (d.getDay() + 6) % 7);
                return parseInt((aDate - d) / 604800000) + 1;
        }
        Twig.lib.formatDate = function(date, format) {
            /// <summary>
            ///   Gets a string for this date, formatted according to the given format
            ///   string.
            /// </summary>
            /// <param name="format" type="String">
            ///   The format of the output date string.  The format string works in a
            ///   nearly identical way to the PHP date function which is highlighted here:
            ///   http://php.net/manual/en/function.date.php.
            ///   The only difference is the fact that "u" signifies milliseconds
            ///   instead of microseconds.  The following characters are recognized in
            ///   the format parameter string:
            ///     d - Day of the month, 2 digits with leading zeros
            ///     D - A textual representation of a day, three letters
            ///     j - Day of the month without leading zeros
            ///     l (lowercase 'L') - A full textual representation of the day of the week
            ///     N - ISO-8601 numeric representation of the day of the week (starting from 1)
            ///     S - English ordinal suffix for the day of the month, 2 characters st,
            ///         nd, rd or th. Works well with j.
            ///     w - Numeric representation of the day of the week (starting from 0)
            ///     z - The day of the year (starting from 0)
            ///     W - ISO-8601 week number of year, weeks starting on Monday
            ///     F - A full textual representation of a month, such as January or March
            ///     m - Numeric representation of a month, with leading zeros
            ///     M - A short textual representation of a month, three letters
            ///     n - Numeric representation of a month, without leading zeros
            ///     t - Number of days in the given month
            ///     L - Whether it's a leap year
            ///     o - ISO-8601 year number. This has the same value as Y, except that if
            ///         the ISO week number (W) belongs to the previous or next year, that
            ///         year is used instead.
            ///     Y - A full numeric representation of a year, 4 digits
            ///     y - A two digit representation of a year
            ///     a - Lowercase Ante meridiem and Post meridiem
            ///     A - Uppercase Ante meridiem and Post meridiem
            ///     B - Swatch Internet time
            ///     g - 12-hour format of an hour without leading zeros
            ///     G - 24-hour format of an hour without leading zeros
            ///     h - 12-hour format of an hour with leading zeros
            ///     H - 24-hour format of an hour with leading zeros
            ///     i - Minutes with leading zeros
            ///     s - Seconds, with leading zeros
            ///     u - Milliseconds
            ///     U - Seconds since the Unix Epoch (January 1 1970 00:00:00 GMT)
            /// </param>
            /// <returns type="String">
            ///   Returns the string for this date, formatted according to the given
            ///   format string.
            /// </returns>
            // If the format was not passed, use the default toString method.
            if(typeof format !== "string" || /^\s*$/.test(format))
                    return date + "";
            var jan1st = new Date(date.getFullYear(), 0, 1);
            var me = date;
            return format.replace(/[dDjlNSwzWFmMntLoYyaABgGhHisuU]/g, function(option) {
                switch(option) {
                    // Day of the month, 2 digits with leading zeros
                    case "d": return ("0" + me.getDate()).replace(/^.+(..)$/, "$1");
                    // A textual representation of a day, three letters
                    case "D": return shortDays[me.getDay()];
                    // Day of the month without leading zeros
                    case "j": return me.getDate();
                    // A full textual representation of the day of the week
                    case "l": return fullDays[me.getDay()];
                    // ISO-8601 numeric representation of the day of the week
                    case "N": return (me.getDay() + 6) % 7 + 1;
                    // English ordinal suffix for the day of the month, 2 characters
                    case "S": return getOrdinalFor(me.getDate());
                    // Numeric representation of the day of the week
                    case "w": return me.getDay();
                    // The day of the year (starting from 0)
                    case "z": return Math.ceil((jan1st - me) / 86400000);
                    // ISO-8601 week number of year, weeks starting on Monday
                    case "W": return ("0" + getISO8601Week(me)).replace(/^.(..)$/, "$1");
                    // A full textual representation of a month, such as January or March
                    case "F": return fullMonths[me.getMonth()];
                    // Numeric representation of a month, with leading zeros
                    case "m": return ("0" + (me.getMonth() + 1)).replace(/^.+(..)$/, "$1");
                    // A short textual representation of a month, three letters
                    case "M": return shortMonths[me.getMonth()];
                    // Numeric representation of a month, without leading zeros
                    case "n": return me.getMonth() + 1;
                    // Number of days in the given month
                    case "t": return new Date(me.getFullYear(), me.getMonth() + 1, -1).getDate();
                    // Whether it's a leap year
                    case "L": return new Date(me.getFullYear(), 1, 29).getDate() == 29 ? 1 : 0;
                    // ISO-8601 year number. This has the same value as Y, except that if the
                    // ISO week number (W) belongs to the previous or next year, that year is
                    // used instead.
                    case "o": return getISO8601Year(me);
                    // A full numeric representation of a year, 4 digits
                    case "Y": return me.getFullYear();
                    // A two digit representation of a year
                    case "y": return (me.getFullYear() + "").replace(/^.+(..)$/, "$1");
                    // Lowercase Ante meridiem and Post meridiem
                    case "a": return me.getHours() < 12 ? "am" : "pm";
                    // Uppercase Ante meridiem and Post meridiem
                    case "A": return me.getHours() < 12 ? "AM" : "PM";
                    // Swatch Internet time
                    case "B": return Math.floor((((me.getUTCHours() + 1) % 24) + me.getUTCMinutes() / 60 + me.getUTCSeconds() / 3600) * 1000 / 24);
                    // 12-hour format of an hour without leading zeros
                    case "g": return me.getHours() % 12 != 0 ? me.getHours() % 12 : 12;
                    // 24-hour format of an hour without leading zeros
                    case "G": return me.getHours();
                    // 12-hour format of an hour with leading zeros
                    case "h": return ("0" + (me.getHours() % 12 != 0 ? me.getHours() % 12 : 12)).replace(/^.+(..)$/, "$1");
                    // 24-hour format of an hour with leading zeros
                    case "H": return ("0" + me.getHours()).replace(/^.+(..)$/, "$1");
                    // Minutes with leading zeros
                    case "i": return ("0" + me.getMinutes()).replace(/^.+(..)$/, "$1");
                    // Seconds, with leading zeros
                    case "s": return ("0" + me.getSeconds()).replace(/^.+(..)$/, "$1");
                    // Milliseconds
                    case "u": return me.getMilliseconds();
                    // Seconds since the Unix Epoch (January 1 1970 00:00:00 GMT)
                    case "U": return me.getTime() / 1000;
                }
            });
        };
    })();

    Twig.lib.strip_tags = function(input, allowed) {
        // Strips HTML and PHP tags from a string
        //
        // version: 1109.2015
        // discuss at: http://phpjs.org/functions/strip_tags
        // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
        // +   improved by: Luke Godfrey
        // +      input by: Pul
        // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
        // +   bugfixed by: Onno Marsman
        // +      input by: Alex
        // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
        // +      input by: Marc Palau
        // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
        // +      input by: Brett Zamir (http://brett-zamir.me)
        // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
        // +   bugfixed by: Eric Nagel
        // +      input by: Bobby Drake
        // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
        // +   bugfixed by: Tomasz Wesolowski
        // +      input by: Evertjan Garretsen
        // +    revised by: Rafał Kukawski (http://blog.kukawski.pl/)
        // *     example 1: strip_tags('<p>Kevin</p> <b>van</b> <i>Zonneveld</i>', '<i><b>');
        // *     returns 1: 'Kevin <b>van</b> <i>Zonneveld</i>'
        // *     example 2: strip_tags('<p>Kevin <img src="someimage.png" onmouseover="someFunction()">van <i>Zonneveld</i></p>', '<p>');
        // *     returns 2: '<p>Kevin van Zonneveld</p>'
        // *     example 3: strip_tags("<a href='http://kevin.vanzonneveld.net'>Kevin van Zonneveld</a>", "<a>");
        // *     returns 3: '<a href='http://kevin.vanzonneveld.net'>Kevin van Zonneveld</a>'
        // *     example 4: strip_tags('1 < 5 5 > 1');
        // *     returns 4: '1 < 5 5 > 1'
        // *     example 5: strip_tags('1 <br/> 1');
        // *     returns 5: '1  1'
        // *     example 6: strip_tags('1 <br/> 1', '<br>');
        // *     returns 6: '1  1'
        // *     example 7: strip_tags('1 <br/> 1', '<br><br/>');
        // *     returns 7: '1 <br/> 1'
        allowed = (((allowed || "") + "").toLowerCase().match(/<[a-z][a-z0-9]*>/g) || []).join(''); // making sure the allowed arg is a string containing only tags in lowercase (<a><b><c>)
        var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,
            commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
        return input.replace(commentsAndPhpTags, '').replace(tags, function ($0, $1) {
            return allowed.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
        });
    }

    Twig.lib.parseISO8601Date = function (s){
        // Taken from http://n8v.enteuxis.org/2010/12/parsing-iso-8601-dates-in-javascript/
        // parenthese matches:
        // year month day    hours minutes seconds  
        // dotmilliseconds 
        // tzstring plusminus hours minutes
        var re = /(\d{4})-(\d\d)-(\d\d)T(\d\d):(\d\d):(\d\d)(\.\d+)?(Z|([+-])(\d\d):(\d\d))/;

        var d = [];
        d = s.match(re);

        // "2010-12-07T11:00:00.000-09:00" parses to:
        //  ["2010-12-07T11:00:00.000-09:00", "2010", "12", "07", "11",
        //     "00", "00", ".000", "-09:00", "-", "09", "00"]
        // "2010-12-07T11:00:00.000Z" parses to:
        //  ["2010-12-07T11:00:00.000Z",      "2010", "12", "07", "11", 
        //     "00", "00", ".000", "Z", undefined, undefined, undefined]

        if (! d) {
            throw "Couldn't parse ISO 8601 date string '" + s + "'";
        }

        // parse strings, leading zeros into proper ints
        var a = [1,2,3,4,5,6,10,11];
        for (var i in a) {
            d[a[i]] = parseInt(d[a[i]], 10);
        }
        d[7] = parseFloat(d[7]);

        // Date.UTC(year, month[, date[, hrs[, min[, sec[, ms]]]]])
        // note that month is 0-11, not 1-12
        // see https://developer.mozilla.org/en/JavaScript/Reference/Global_Objects/Date/UTC
        var ms = Date.UTC(d[1], d[2] - 1, d[3], d[4], d[5], d[6]);

        // if there are milliseconds, add them
        if (d[7] > 0) {  
            ms += Math.round(d[7] * 1000);
        }

        // if there's a timezone, calculate it
        if (d[8] != "Z" && d[10]) {
            var offset = d[10] * 60 * 60 * 1000;
            if (d[11]) {
                offset += d[11] * 60 * 1000;
            }
            if (d[9] == "-") {
                ms -= offset;
            }
            else {
                ms += offset;
            }
        }

        return new Date(ms);
    };

    Twig.lib.strtotime = function (text, now) {
      //  discuss at: http://phpjs.org/functions/strtotime/
      //     version: 1109.2016
      // original by: Caio Ariede (http://caioariede.com)
      // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
      // improved by: Caio Ariede (http://caioariede.com)
      // improved by: A. Matías Quezada (http://amatiasq.com)
      // improved by: preuter
      // improved by: Brett Zamir (http://brett-zamir.me)
      // improved by: Mirko Faber
      //    input by: David
      // bugfixed by: Wagner B. Soares
      // bugfixed by: Artur Tchernychev
      // bugfixed by: Stephan Bösch-Plepelits (http://github.com/plepe)
      //        note: Examples all have a fixed timestamp to prevent tests to fail because of variable time(zones)
      //   example 1: strtotime('+1 day', 1129633200);
      //   returns 1: 1129719600
      //   example 2: strtotime('+1 week 2 days 4 hours 2 seconds', 1129633200);
      //   returns 2: 1130425202
      //   example 3: strtotime('last month', 1129633200);
      //   returns 3: 1127041200
      //   example 4: strtotime('2009-05-04 08:30:00 GMT');
      //   returns 4: 1241425800
      //   example 5: strtotime('2009-05-04 08:30:00+00');
      //   returns 5: 1241425800
      //   example 6: strtotime('2009-05-04 08:30:00+02:00');
      //   returns 6: 1241418600
      //   example 7: strtotime('2009-05-04T08:30:00Z');
      //   returns 7: 1241425800

      var parsed, match, today, year, date, days, ranges, len, times, regex, i, fail = false;

      if (!text) {
	return fail;
      }

      // Unecessary spaces
      text = text.replace(/^\s+|\s+$/g, '')
	.replace(/\s{2,}/g, ' ')
	.replace(/[\t\r\n]/g, '')
	.toLowerCase();

      // in contrast to php, js Date.parse function interprets:
      // dates given as yyyy-mm-dd as in timezone: UTC,
      // dates with "." or "-" as MDY instead of DMY
      // dates with two-digit years differently
      // etc...etc...
      // ...therefore we manually parse lots of common date formats
      match = text.match(
	/^(\d{1,4})([\-\.\/\:])(\d{1,2})([\-\.\/\:])(\d{1,4})(?:\s(\d{1,2}):(\d{2})?:?(\d{2})?)?(?:\s([A-Z]+)?)?$/);

      if (match && match[2] === match[4]) {
	if (match[1] > 1901) {
	  switch (match[2]) {
	  case '-':
	    {
	      // YYYY-M-D
	      if (match[3] > 12 || match[5] > 31) {
		return fail;
	      }

	      return new Date(match[1], parseInt(match[3], 10) - 1, match[5],
		match[6] || 0, match[7] || 0, match[8] || 0, match[9] || 0) / 1000;
	    }
	  case '.':
	    {
	      // YYYY.M.D is not parsed by strtotime()
	      return fail;
	    }
	  case '/':
	    {
	      // YYYY/M/D
	      if (match[3] > 12 || match[5] > 31) {
		return fail;
	      }

	      return new Date(match[1], parseInt(match[3], 10) - 1, match[5],
		match[6] || 0, match[7] || 0, match[8] || 0, match[9] || 0) / 1000;
	    }
	  }
	} else if (match[5] > 1901) {
	  switch (match[2]) {
	  case '-':
	    {
	      // D-M-YYYY
	      if (match[3] > 12 || match[1] > 31) {
		return fail;
	      }

	      return new Date(match[5], parseInt(match[3], 10) - 1, match[1],
		match[6] || 0, match[7] || 0, match[8] || 0, match[9] || 0) / 1000;
	    }
	  case '.':
	    {
	      // D.M.YYYY
	      if (match[3] > 12 || match[1] > 31) {
		return fail;
	      }

	      return new Date(match[5], parseInt(match[3], 10) - 1, match[1],
		match[6] || 0, match[7] || 0, match[8] || 0, match[9] || 0) / 1000;
	    }
	  case '/':
	    {
	      // M/D/YYYY
	      if (match[1] > 12 || match[3] > 31) {
		return fail;
	      }

	      return new Date(match[5], parseInt(match[1], 10) - 1, match[3],
		match[6] || 0, match[7] || 0, match[8] || 0, match[9] || 0) / 1000;
	    }
	  }
	} else {
	  switch (match[2]) {
	  case '-':
	    {
	      // YY-M-D
	      if (match[3] > 12 || match[5] > 31 || (match[1] < 70 && match[1] > 38)) {
		return fail;
	      }

	      year = match[1] >= 0 && match[1] <= 38 ? +match[1] + 2000 : match[1];
	      return new Date(year, parseInt(match[3], 10) - 1, match[5],
		match[6] || 0, match[7] || 0, match[8] || 0, match[9] || 0) / 1000;
	    }
	  case '.':
	    {
	      // D.M.YY or H.MM.SS
	      if (match[5] >= 70) {
		// D.M.YY
		if (match[3] > 12 || match[1] > 31) {
		  return fail;
		}

		return new Date(match[5], parseInt(match[3], 10) - 1, match[1],
		  match[6] || 0, match[7] || 0, match[8] || 0, match[9] || 0) / 1000;
	      }
	      if (match[5] < 60 && !match[6]) {
		// H.MM.SS
		if (match[1] > 23 || match[3] > 59) {
		  return fail;
		}

		today = new Date();
		return new Date(today.getFullYear(), today.getMonth(), today.getDate(),
		  match[1] || 0, match[3] || 0, match[5] || 0, match[9] || 0) / 1000;
	      }

	      // invalid format, cannot be parsed
	      return fail;
	    }
	  case '/':
	    {
	      // M/D/YY
	      if (match[1] > 12 || match[3] > 31 || (match[5] < 70 && match[5] > 38)) {
		return fail;
	      }

	      year = match[5] >= 0 && match[5] <= 38 ? +match[5] + 2000 : match[5];
	      return new Date(year, parseInt(match[1], 10) - 1, match[3],
		match[6] || 0, match[7] || 0, match[8] || 0, match[9] || 0) / 1000;
	    }
	  case ':':
	    {
	      // HH:MM:SS
	      if (match[1] > 23 || match[3] > 59 || match[5] > 59) {
		return fail;
	      }

	      today = new Date();
	      return new Date(today.getFullYear(), today.getMonth(), today.getDate(),
		match[1] || 0, match[3] || 0, match[5] || 0) / 1000;
	    }
	  }
	}
      }

      // other formats and "now" should be parsed by Date.parse()
      if (text === 'now') {
	return now === null || isNaN(now) ? new Date()
	  .getTime() / 1000 | 0 : now | 0;
      }
      if (!isNaN(parsed = Date.parse(text))) {
	return parsed / 1000 | 0;
      }
      // Browsers != Chrome have problems parsing ISO 8601 date strings, as they do
      // not accept lower case characters, space, or shortened time zones.
      // Therefore, fix these problems and try again.
      // Examples:
      //   2015-04-15 20:33:59+02
      //   2015-04-15 20:33:59z
      //   2015-04-15t20:33:59+02:00
      if (match = text.match(/^([0-9]{4}-[0-9]{2}-[0-9]{2})[ t]([0-9]{2}:[0-9]{2}:[0-9]{2}(\.[0-9]+)?)([\+-][0-9]{2}(:[0-9]{2})?|z)/)) {
	// fix time zone information
	if (match[4] == 'z') {
	  match[4] = 'Z';
	}
	else if (match[4].match(/^([\+-][0-9]{2})$/)) {
	  match[4] = match[4] + ':00';
	}

	if (!isNaN(parsed = Date.parse(match[1] + 'T' + match[2] + match[4]))) {
	  return parsed / 1000 | 0;
	}
      }

      date = now ? new Date(now * 1000) : new Date();
      days = {
	'sun': 0,
	'mon': 1,
	'tue': 2,
	'wed': 3,
	'thu': 4,
	'fri': 5,
	'sat': 6
      };
      ranges = {
	'yea': 'FullYear',
	'mon': 'Month',
	'day': 'Date',
	'hou': 'Hours',
	'min': 'Minutes',
	'sec': 'Seconds'
      };

      function lastNext(type, range, modifier) {
	var diff, day = days[range];

	if (typeof day !== 'undefined') {
	  diff = day - date.getDay();

	  if (diff === 0) {
	    diff = 7 * modifier;
	  } else if (diff > 0 && type === 'last') {
	    diff -= 7;
	  } else if (diff < 0 && type === 'next') {
	    diff += 7;
	  }

	  date.setDate(date.getDate() + diff);
	}
      }

      function process(val) {
	var splt = val.split(' '), // Todo: Reconcile this with regex using \s, taking into account browser issues with split and regexes
	  type = splt[0],
	  range = splt[1].substring(0, 3),
	  typeIsNumber = /\d+/.test(type),
	  ago = splt[2] === 'ago',
	  num = (type === 'last' ? -1 : 1) * (ago ? -1 : 1);

	if (typeIsNumber) {
	  num *= parseInt(type, 10);
	}

	if (ranges.hasOwnProperty(range) && !splt[1].match(/^mon(day|\.)?$/i)) {
	  return date['set' + ranges[range]](date['get' + ranges[range]]() + num);
	}

	if (range === 'wee') {
	  return date.setDate(date.getDate() + (num * 7));
	}

	if (type === 'next' || type === 'last') {
	  lastNext(type, range, num);
	} else if (!typeIsNumber) {
	  return false;
	}

	return true;
      }

      times = '(years?|months?|weeks?|days?|hours?|minutes?|min|seconds?|sec' +
	'|sunday|sun\\.?|monday|mon\\.?|tuesday|tue\\.?|wednesday|wed\\.?' +
	'|thursday|thu\\.?|friday|fri\\.?|saturday|sat\\.?)';
      regex = '([+-]?\\d+\\s' + times + '|' + '(last|next)\\s' + times + ')(\\sago)?';

      match = text.match(new RegExp(regex, 'gi'));
      if (!match) {
	return fail;
      }

      for (i = 0, len = match.length; i < len; i++) {
	if (!process(match[i])) {
	  return fail;
	}
      }

      // ECMAScript 5 only
      // if (!match.every(process))
      //    return false;

      return (date.getTime() / 1000);
    };

    Twig.lib.is = function(type, obj) {
        var clas = Object.prototype.toString.call(obj).slice(8, -1);
        return obj !== undefined && obj !== null && clas === type;
    };

    // shallow-copy an object
    Twig.lib.copy = function(src) {
        var target = {},
            key;
        for (key in src)
            target[key] = src[key];

        return target;
    };

    Twig.lib.replaceAll = function(string, search, replace) {
        return string.split(search).join(replace);
    };

    // chunk an array (arr) into arrays of (size) items, returns an array of arrays, or an empty array on invalid input
    Twig.lib.chunkArray = function (arr, size) {
        var returnVal = [],
            x = 0,
            len = arr.length;

        if (size < 1 || !Twig.lib.is("Array", arr)) {
            return [];
        }

        while (x < len) {
            returnVal.push(arr.slice(x, x += size));
        }

        return returnVal;
    };

    Twig.lib.round = function round(value, precision, mode) {
        //  discuss at: http://phpjs.org/functions/round/
        // original by: Philip Peterson
        //  revised by: Onno Marsman
        //  revised by: T.Wild
        //  revised by: Rafał Kukawski (http://blog.kukawski.pl/)
        //    input by: Greenseed
        //    input by: meo
        //    input by: William
        //    input by: Josep Sanz (http://www.ws3.es/)
        // bugfixed by: Brett Zamir (http://brett-zamir.me)
        //        note: Great work. Ideas for improvement:
        //        note: - code more compliant with developer guidelines
        //        note: - for implementing PHP constant arguments look at
        //        note: the pathinfo() function, it offers the greatest
        //        note: flexibility & compatibility possible
        //   example 1: round(1241757, -3);
        //   returns 1: 1242000
        //   example 2: round(3.6);
        //   returns 2: 4
        //   example 3: round(2.835, 2);
        //   returns 3: 2.84
        //   example 4: round(1.1749999999999, 2);
        //   returns 4: 1.17
        //   example 5: round(58551.799999999996, 2);
        //   returns 5: 58551.8

        var m, f, isHalf, sgn; // helper variables
        precision |= 0; // making sure precision is integer
        m = Math.pow(10, precision);
        value *= m;
        sgn = (value > 0) | -(value < 0); // sign of the number
        isHalf = value % 1 === 0.5 * sgn;
        f = Math.floor(value);

        if (isHalf) {
            switch (mode) {
                case 'PHP_ROUND_HALF_DOWN':
                    value = f + (sgn < 0); // rounds .5 toward zero
                    break;
                case 'PHP_ROUND_HALF_EVEN':
                    value = f + (f % 2 * sgn); // rouds .5 towards the next even integer
                    break;
                case 'PHP_ROUND_HALF_ODD':
                    value = f + !(f % 2); // rounds .5 towards the next odd integer
                    break;
                default:
                    value = f + (sgn > 0); // rounds .5 away from zero
            }
        }

        return (isHalf ? value : Math.round(value)) / m;
    };

    Twig.lib.max = function max() {
        //  discuss at: http://phpjs.org/functions/max/
        // original by: Onno Marsman
        //  revised by: Onno Marsman
        // improved by: Jack
        //        note: Long code cause we're aiming for maximum PHP compatibility
        //   example 1: max(1, 3, 5, 6, 7);
        //   returns 1: 7
        //   example 2: max([2, 4, 5]);
        //   returns 2: 5
        //   example 3: max(0, 'hello');
        //   returns 3: 0
        //   example 4: max('hello', 0);
        //   returns 4: 'hello'
        //   example 5: max(-1, 'hello');
        //   returns 5: 'hello'
        //   example 6: max([2, 4, 8], [2, 5, 7]);
        //   returns 6: [2, 5, 7]

        var ar, retVal, i = 0,
            n = 0,
            argv = arguments,
            argc = argv.length,
            _obj2Array = function(obj) {
                if (Object.prototype.toString.call(obj) === '[object Array]') {
                    return obj;
                } else {
                    var ar = [];
                    for (var i in obj) {
                        if (obj.hasOwnProperty(i)) {
                            ar.push(obj[i]);
                        }
                    }
                    return ar;
                }
            }, //function _obj2Array
            _compare = function(current, next) {
                var i = 0,
                    n = 0,
                    tmp = 0,
                    nl = 0,
                    cl = 0;

                if (current === next) {
                    return 0;
                } else if (typeof current === 'object') {
                    if (typeof next === 'object') {
                        current = _obj2Array(current);
                        next = _obj2Array(next);
                        cl = current.length;
                        nl = next.length;
                        if (nl > cl) {
                            return 1;
                        } else if (nl < cl) {
                            return -1;
                        }
                        for (i = 0, n = cl; i < n; ++i) {
                            tmp = _compare(current[i], next[i]);
                            if (tmp == 1) {
                                return 1;
                            } else if (tmp == -1) {
                                return -1;
                            }
                        }
                        return 0;
                    }
                    return -1;
                } else if (typeof next === 'object') {
                    return 1;
                } else if (isNaN(next) && !isNaN(current)) {
                    if (current == 0) {
                        return 0;
                    }
                    return (current < 0 ? 1 : -1);
                } else if (isNaN(current) && !isNaN(next)) {
                    if (next == 0) {
                        return 0;
                    }
                    return (next > 0 ? 1 : -1);
                }

                if (next == current) {
                    return 0;
                }
                return (next > current ? 1 : -1);
            }; //function _compare
        if (argc === 0) {
            throw new Error('At least one value should be passed to max()');
        } else if (argc === 1) {
            if (typeof argv[0] === 'object') {
                ar = _obj2Array(argv[0]);
            } else {
                throw new Error('Wrong parameter count for max()');
            }
            if (ar.length === 0) {
                throw new Error('Array must contain at least one element for max()');
            }
        } else {
            ar = argv;
        }

        retVal = ar[0];
        for (i = 1, n = ar.length; i < n; ++i) {
            if (_compare(retVal, ar[i]) == 1) {
                retVal = ar[i];
            }
        }

        return retVal;
    };

    Twig.lib.min = function min() {
        //  discuss at: http://phpjs.org/functions/min/
        // original by: Onno Marsman
        //  revised by: Onno Marsman
        // improved by: Jack
        //        note: Long code cause we're aiming for maximum PHP compatibility
        //   example 1: min(1, 3, 5, 6, 7);
        //   returns 1: 1
        //   example 2: min([2, 4, 5]);
        //   returns 2: 2
        //   example 3: min(0, 'hello');
        //   returns 3: 0
        //   example 4: min('hello', 0);
        //   returns 4: 'hello'
        //   example 5: min(-1, 'hello');
        //   returns 5: -1
        //   example 6: min([2, 4, 8], [2, 5, 7]);
        //   returns 6: [2, 4, 8]

        var ar, retVal, i = 0,
            n = 0,
            argv = arguments,
            argc = argv.length,
            _obj2Array = function(obj) {
                if (Object.prototype.toString.call(obj) === '[object Array]') {
                    return obj;
                }
                var ar = [];
                for (var i in obj) {
                    if (obj.hasOwnProperty(i)) {
                        ar.push(obj[i]);
                    }
                }
                return ar;
            }, //function _obj2Array
            _compare = function(current, next) {
                var i = 0,
                    n = 0,
                    tmp = 0,
                    nl = 0,
                    cl = 0;

                if (current === next) {
                    return 0;
                } else if (typeof current === 'object') {
                    if (typeof next === 'object') {
                        current = _obj2Array(current);
                        next = _obj2Array(next);
                        cl = current.length;
                        nl = next.length;
                        if (nl > cl) {
                            return 1;
                        } else if (nl < cl) {
                            return -1;
                        }
                        for (i = 0, n = cl; i < n; ++i) {
                            tmp = _compare(current[i], next[i]);
                            if (tmp == 1) {
                                return 1;
                            } else if (tmp == -1) {
                                return -1;
                            }
                        }
                        return 0;
                    }
                    return -1;
                } else if (typeof next === 'object') {
                    return 1;
                } else if (isNaN(next) && !isNaN(current)) {
                    if (current == 0) {
                        return 0;
                    }
                    return (current < 0 ? 1 : -1);
                } else if (isNaN(current) && !isNaN(next)) {
                    if (next == 0) {
                        return 0;
                    }
                    return (next > 0 ? 1 : -1);
                }

                if (next == current) {
                    return 0;
                }
                return (next > current ? 1 : -1);
            }; //function _compare

        if (argc === 0) {
            throw new Error('At least one value should be passed to min()');
        } else if (argc === 1) {
            if (typeof argv[0] === 'object') {
                ar = _obj2Array(argv[0]);
            } else {
                throw new Error('Wrong parameter count for min()');
            }

            if (ar.length === 0) {
                throw new Error('Array must contain at least one element for min()');
            }
        } else {
            ar = argv;
        }

        retVal = ar[0];

        for (i = 1, n = ar.length; i < n; ++i) {
            if (_compare(retVal, ar[i]) == -1) {
                retVal = ar[i];
            }
        }

        return retVal;
    };

    return Twig;

})(Twig || { });
//     Twig.js
//     Available under the BSD 2-Clause License
//     https://github.com/justjohn/twig.js

// ## twig.logic.js
//
// This file handles tokenizing, compiling and parsing logic tokens. {% ... %}
var Twig = (function (Twig) {
    "use strict";

    /**
     * Namespace for logic handling.
     */
    Twig.logic = {};

    /**
     * Logic token types.
     */
    Twig.logic.type = {
        if_:       'Twig.logic.type.if',
        endif:     'Twig.logic.type.endif',
        for_:      'Twig.logic.type.for',
        endfor:    'Twig.logic.type.endfor',
        else_:     'Twig.logic.type.else',
        elseif:    'Twig.logic.type.elseif',
        set:       'Twig.logic.type.set',
        setcapture:'Twig.logic.type.setcapture',
        endset:    'Twig.logic.type.endset',
        filter:    'Twig.logic.type.filter',
        endfilter: 'Twig.logic.type.endfilter',
        shortblock: 'Twig.logic.type.shortblock',
        block:     'Twig.logic.type.block',
        endblock:  'Twig.logic.type.endblock',
        extends_:  'Twig.logic.type.extends',
        use:       'Twig.logic.type.use',
        include:   'Twig.logic.type.include',
        spaceless: 'Twig.logic.type.spaceless',
        endspaceless: 'Twig.logic.type.endspaceless',
        macro:     'Twig.logic.type.macro',
        endmacro:  'Twig.logic.type.endmacro',
        import_:   'Twig.logic.type.import',
        from:      'Twig.logic.type.from',
        embed:     'Twig.logic.type.embed',
        endembed:  'Twig.logic.type.endembed'
    };


    // Regular expressions for handling logic tokens.
    //
    // Properties:
    //
    //      type:  The type of expression this matches
    //
    //      regex: A regular expression that matches the format of the token
    //
    //      next:  What logic tokens (if any) pop this token off the logic stack. If empty, the
    //             logic token is assumed to not require an end tag and isn't push onto the stack.
    //
    //      open:  Does this tag open a logic expression or is it standalone. For example,
    //             {% endif %} cannot exist without an opening {% if ... %} tag, so open = false.
    //
    //  Functions:
    //
    //      compile: A function that handles compiling the token into an output token ready for
    //               parsing with the parse function.
    //
    //      parse:   A function that parses the compiled token into output (HTML / whatever the
    //               template represents).
    Twig.logic.definitions = [
        {
            /**
             * If type logic tokens.
             *
             *  Format: {% if expression %}
             */
            type: Twig.logic.type.if_,
            regex: /^if\s+([\s\S]+)$/,
            next: [
                Twig.logic.type.else_,
                Twig.logic.type.elseif,
                Twig.logic.type.endif
            ],
            open: true,
            compile: function (token) {
                var expression = token.match[1];
                // Compile the expression.
                token.stack = Twig.expression.compile.apply(this, [{
                    type:  Twig.expression.type.expression,
                    value: expression
                }]).stack;
                delete token.match;
                return token;
            },
            parse: function (token, context, chain) {
                var output = '',
                    // Parse the expression
                    result = Twig.expression.parse.apply(this, [token.stack, context]);

                // Start a new logic chain
                chain = true;

                if (result) {
                    chain = false;
                    // parse if output
                    output = Twig.parse.apply(this, [token.output, context]);
                }
                return {
                    chain: chain,
                    output: output
                };
            }
        },
        {
            /**
             * Else if type logic tokens.
             *
             *  Format: {% elseif expression %}
             */
            type: Twig.logic.type.elseif,
            regex: /^elseif\s+([^\s].*)$/,
            next: [
                Twig.logic.type.else_,
                Twig.logic.type.elseif,
                Twig.logic.type.endif
            ],
            open: false,
            compile: function (token) {
                var expression = token.match[1];
                // Compile the expression.
                token.stack = Twig.expression.compile.apply(this, [{
                    type:  Twig.expression.type.expression,
                    value: expression
                }]).stack;
                delete token.match;
                return token;
            },
            parse: function (token, context, chain) {
                var output = '';

                if (chain && Twig.expression.parse.apply(this, [token.stack, context]) === true) {
                    chain = false;
                    // parse if output
                    output = Twig.parse.apply(this, [token.output, context]);
                }

                return {
                    chain: chain,
                    output: output
                };
            }
        },
        {
            /**
             * Else if type logic tokens.
             *
             *  Format: {% elseif expression %}
             */
            type: Twig.logic.type.else_,
            regex: /^else$/,
            next: [
                Twig.logic.type.endif,
                Twig.logic.type.endfor
            ],
            open: false,
            parse: function (token, context, chain) {
                var output = '';
                if (chain) {
                    output = Twig.parse.apply(this, [token.output, context]);
                }
                return {
                    chain: chain,
                    output: output
                };
            }
        },
        {
            /**
             * End if type logic tokens.
             *
             *  Format: {% endif %}
             */
            type: Twig.logic.type.endif,
            regex: /^endif$/,
            next: [ ],
            open: false
        },
        {
            /**
             * For type logic tokens.
             *
             *  Format: {% for expression %}
             */
            type: Twig.logic.type.for_,
            regex: /^for\s+([a-zA-Z0-9_,\s]+)\s+in\s+([^\s].*?)(?:\s+if\s+([^\s].*))?$/,
            next: [
                Twig.logic.type.else_,
                Twig.logic.type.endfor
            ],
            open: true,
            compile: function (token) {
                var key_value = token.match[1],
                    expression = token.match[2],
                    conditional = token.match[3],
                    kv_split = null;

                token.key_var = null;
                token.value_var = null;

                if (key_value.indexOf(",") >= 0) {
                    kv_split = key_value.split(',');
                    if (kv_split.length === 2) {
                        token.key_var = kv_split[0].trim();
                        token.value_var = kv_split[1].trim();
                    } else {
                        throw new Twig.Error("Invalid expression in for loop: " + key_value);
                    }
                } else {
                    token.value_var = key_value;
                }

                // Valid expressions for a for loop
                //   for item     in expression
                //   for key,item in expression

                // Compile the expression.
                token.expression = Twig.expression.compile.apply(this, [{
                    type:  Twig.expression.type.expression,
                    value: expression
                }]).stack;

                // Compile the conditional (if available)
                if (conditional) {
                    token.conditional = Twig.expression.compile.apply(this, [{
                        type:  Twig.expression.type.expression,
                        value: conditional
                    }]).stack;
                }

                delete token.match;
                return token;
            },
            parse: function (token, context, continue_chain) {
                // Parse expression
                var result = Twig.expression.parse.apply(this, [token.expression, context]),
                    output = [],
                    len,
                    index = 0,
                    keyset,
                    that = this,
                    conditional = token.conditional,
                    buildLoop = function(index, len) {
                        var isConditional = conditional !== undefined;
                        return {
                            index: index+1,
                            index0: index,
                            revindex: isConditional?undefined:len-index,
                            revindex0: isConditional?undefined:len-index-1,
                            first: (index === 0),
                            last: isConditional?undefined:(index === len-1),
                            length: isConditional?undefined:len,
                            parent: context
                        };
                    },
                    // run once for each iteration of the loop
                    loop = function(key, value) {
                        var inner_context = Twig.ChildContext(context);

                        inner_context[token.value_var] = value;

                        if (token.key_var) {
                            inner_context[token.key_var] = key;
                        }

                        // Loop object
                        inner_context.loop = buildLoop(index, len);

                        if (conditional === undefined ||
                            Twig.expression.parse.apply(that, [conditional, inner_context]))
                        {
                            output.push(Twig.parse.apply(that, [token.output, inner_context]));
                            index += 1;
                        }

                        // Delete loop-related variables from the context
                        delete inner_context['loop'];
                        delete inner_context[token.value_var];
                        delete inner_context[token.key_var];

                        // Merge in values that exist in context but have changed
                        // in inner_context.
                        Twig.merge(context, inner_context, true);
                    };


                if (Twig.lib.is('Array', result)) {
                    len = result.length;
                    Twig.forEach(result, function (value) {
                        var key = index;

                        loop(key, value);
                    });
                } else if (Twig.lib.is('Object', result)) {
                    if (result._keys !== undefined) {
                        keyset = result._keys;
                    } else {
                        keyset = Object.keys(result);
                    }
                    len = keyset.length;
                    Twig.forEach(keyset, function(key) {
                        // Ignore the _keys property, it's internal to twig.js
                        if (key === "_keys") return;

                        loop(key,  result[key]);
                    });
                }

                // Only allow else statements if no output was generated
                continue_chain = (output.length === 0);

                return {
                    chain: continue_chain,
                    output: Twig.output.apply(this, [output])
                };
            }
        },
        {
            /**
             * End if type logic tokens.
             *
             *  Format: {% endif %}
             */
            type: Twig.logic.type.endfor,
            regex: /^endfor$/,
            next: [ ],
            open: false
        },
        {
            /**
             * Set type logic tokens.
             *
             *  Format: {% set key = expression %}
             */
            type: Twig.logic.type.set,
            regex: /^set\s+([a-zA-Z0-9_,\s]+)\s*=\s*([\s\S]+)$/,
            next: [ ],
            open: true,
            compile: function (token) {
                var key = token.match[1].trim(),
                    expression = token.match[2],
                    // Compile the expression.
                    expression_stack  = Twig.expression.compile.apply(this, [{
                        type:  Twig.expression.type.expression,
                        value: expression
                    }]).stack;

                token.key = key;
                token.expression = expression_stack;

                delete token.match;
                return token;
            },
            parse: function (token, context, continue_chain) {
                var value = Twig.expression.parse.apply(this, [token.expression, context]),
                    key = token.key;

                context[key] = value;

                return {
                    chain: continue_chain,
                    context: context
                };
            }
        },
        {
            /**
             * Set capture type logic tokens.
             *
             *  Format: {% set key %}
             */
            type: Twig.logic.type.setcapture,
            regex: /^set\s+([a-zA-Z0-9_,\s]+)$/,
            next: [
                Twig.logic.type.endset
            ],
            open: true,
            compile: function (token) {
                var key = token.match[1].trim();

                token.key = key;

                delete token.match;
                return token;
            },
            parse: function (token, context, continue_chain) {

                var value = Twig.parse.apply(this, [token.output, context]),
                    key = token.key;

                // set on both the global and local context
                this.context[key] = value;
                context[key] = value;

                return {
                    chain: continue_chain,
                    context: context
                };
            }
        },
        {
            /**
             * End set type block logic tokens.
             *
             *  Format: {% endset %}
             */
            type: Twig.logic.type.endset,
            regex: /^endset$/,
            next: [ ],
            open: false
        },
        {
            /**
             * Filter logic tokens.
             *
             *  Format: {% filter upper %} or {% filter lower|escape %}
             */
            type: Twig.logic.type.filter,
            regex: /^filter\s+(.+)$/,
            next: [
                Twig.logic.type.endfilter
            ],
            open: true,
            compile: function (token) {
                var expression = "|" + token.match[1].trim();
                // Compile the expression.
                token.stack = Twig.expression.compile.apply(this, [{
                    type:  Twig.expression.type.expression,
                    value: expression
                }]).stack;
                delete token.match;
                return token;
            },
            parse: function (token, context, chain) {
                var unfiltered = Twig.parse.apply(this, [token.output, context]),
                    stack = [{
                        type: Twig.expression.type.string,
                        value: unfiltered
                    }].concat(token.stack);

                var output = Twig.expression.parse.apply(this, [stack, context]);

                return {
                    chain: chain,
                    output: output
                };
            }
        },
        {
            /**
             * End filter logic tokens.
             *
             *  Format: {% endfilter %}
             */
            type: Twig.logic.type.endfilter,
            regex: /^endfilter$/,
            next: [ ],
            open: false
        },
        {
            /**
             * Block logic tokens.
             *
             *  Format: {% block title %}
             */
            type: Twig.logic.type.block,
            regex: /^block\s+([a-zA-Z0-9_]+)$/,
            next: [
                Twig.logic.type.endblock
            ],
            open: true,
            compile: function (token) {
                token.block = token.match[1].trim();
                delete token.match;
                return token;
            },
            parse: function (token, context, chain) {
                var block_output,
                    output,
                    isImported = Twig.indexOf(this.importedBlocks, token.block) > -1,
                    hasParent = this.blocks[token.block] && Twig.indexOf(this.blocks[token.block], Twig.placeholders.parent) > -1;

                // Don't override previous blocks unless they're imported with "use"
                // Loops should be exempted as well.
                if (this.blocks[token.block] === undefined || isImported || hasParent || context.loop || token.overwrite) {
                    if (token.expression) {
                        // Short blocks have output as an expression on the open tag (no body)
                        block_output = Twig.expression.parse.apply(this, [{
                            type: Twig.expression.type.string,
                            value: Twig.expression.parse.apply(this, [token.output, context])
                        }, context]);
                    } else {
                        block_output = Twig.expression.parse.apply(this, [{
                            type: Twig.expression.type.string,
                            value: Twig.parse.apply(this, [token.output, context])
                        }, context]);
                    }

                    if (isImported) {
                        // once the block is overridden, remove it from the list of imported blocks
                        this.importedBlocks.splice(this.importedBlocks.indexOf(token.block), 1);
                    }

                    if (hasParent) {
                        this.blocks[token.block] = Twig.Markup(this.blocks[token.block].replace(Twig.placeholders.parent, block_output));
                    } else {
                        this.blocks[token.block] = block_output;
                    }

                    this.originalBlockTokens[token.block] = {
                        type: token.type,
                        block: token.block,
                        output: token.output,
                        overwrite: true
                    };
                }

                // Check if a child block has been set from a template extending this one.
                if (this.child.blocks[token.block]) {
                    output = this.child.blocks[token.block];
                } else {
                    output = this.blocks[token.block];
                }

                return {
                    chain: chain,
                    output: output
                };
            }
        },
        {
            /**
             * Block shorthand logic tokens.
             *
             *  Format: {% block title expression %}
             */
            type: Twig.logic.type.shortblock,
            regex: /^block\s+([a-zA-Z0-9_]+)\s+(.+)$/,
            next: [ ],
            open: true,
            compile: function (token) {
                token.expression = token.match[2].trim();

                token.output = Twig.expression.compile({
                    type: Twig.expression.type.expression,
                    value: token.expression
                }).stack;

                token.block = token.match[1].trim();
                delete token.match;
                return token;
            },
            parse: function (token, context, chain) {
                return Twig.logic.handler[Twig.logic.type.block].parse.apply(this, arguments);
            }
        },
        {
            /**
             * End block logic tokens.
             *
             *  Format: {% endblock %}
             */
            type: Twig.logic.type.endblock,
            regex: /^endblock(?:\s+([a-zA-Z0-9_]+))?$/,
            next: [ ],
            open: false
        },
        {
            /**
             * Block logic tokens.
             *
             *  Format: {% extends "template.twig" %}
             */
            type: Twig.logic.type.extends_,
            regex: /^extends\s+(.+)$/,
            next: [ ],
            open: true,
            compile: function (token) {
                var expression = token.match[1].trim();
                delete token.match;

                token.stack   = Twig.expression.compile.apply(this, [{
                    type:  Twig.expression.type.expression,
                    value: expression
                }]).stack;

                return token;
            },
            parse: function (token, context, chain) {
                // Resolve filename
                var file = Twig.expression.parse.apply(this, [token.stack, context]);

                // Set parent template
                this.extend = file;

                return {
                    chain: chain,
                    output: ''
                };
            }
        },
        {
            /**
             * Block logic tokens.
             *
             *  Format: {% use "template.twig" %}
             */
            type: Twig.logic.type.use,
            regex: /^use\s+(.+)$/,
            next: [ ],
            open: true,
            compile: function (token) {
                var expression = token.match[1].trim();
                delete token.match;

                token.stack = Twig.expression.compile.apply(this, [{
                    type:  Twig.expression.type.expression,
                    value: expression
                }]).stack;

                return token;
            },
            parse: function (token, context, chain) {
                // Resolve filename
                var file = Twig.expression.parse.apply(this, [token.stack, context]);

                // Import blocks
                this.importBlocks(file);

                return {
                    chain: chain,
                    output: ''
                };
            }
        },
        {
            /**
             * Block logic tokens.
             *
             *  Format: {% includes "template.twig" [with {some: 'values'} only] %}
             */
            type: Twig.logic.type.include,
            regex: /^include\s+(ignore missing\s+)?(.+?)\s*(?:with\s+([\S\s]+?))?\s*(only)?$/,
            next: [ ],
            open: true,
            compile: function (token) {
                var match = token.match,
                    includeMissing = match[1] !== undefined,
                    expression = match[2].trim(),
                    withContext = match[3],
                    only = ((match[4] !== undefined) && match[4].length);

                delete token.match;

                token.only = only;
                token.includeMissing = includeMissing;

                token.stack = Twig.expression.compile.apply(this, [{
                    type:  Twig.expression.type.expression,
                    value: expression
                }]).stack;

                if (withContext !== undefined) {
                    token.withStack = Twig.expression.compile.apply(this, [{
                        type:  Twig.expression.type.expression,
                        value: withContext.trim()
                    }]).stack;
                }

                return token;
            },
            parse: function (token, context, chain) {
                // Resolve filename
                var innerContext = {},
                    withContext,
                    i,
                    template;

                if (!token.only) {
                    innerContext = Twig.ChildContext(context);
                }

                if (token.withStack !== undefined) {
                    withContext = Twig.expression.parse.apply(this, [token.withStack, context]);

                    for (i in withContext) {
                        if (withContext.hasOwnProperty(i))
                            innerContext[i] = withContext[i];
                    }
                }

                var file = Twig.expression.parse.apply(this, [token.stack, innerContext]);

                if (file instanceof Twig.Template) {
                    template = file;
                } else {
                    // Import file
                    template = this.importFile(file);
                }

                return {
                    chain: chain,
                    output: template.render(innerContext)
                };
            }
        },
        {
            type: Twig.logic.type.spaceless,
            regex: /^spaceless$/,
            next: [
                Twig.logic.type.endspaceless
            ],
            open: true,

            // Parse the html and return it without any spaces between tags
            parse: function (token, context, chain) {
                var // Parse the output without any filter
                    unfiltered = Twig.parse.apply(this, [token.output, context]),
                    // A regular expression to find closing and opening tags with spaces between them
                    rBetweenTagSpaces = />\s+</g,
                    // Replace all space between closing and opening html tags
                    output = unfiltered.replace(rBetweenTagSpaces,'><').trim();

                return {
                    chain: chain,
                    output: output
                };
            }
        },

        // Add the {% endspaceless %} token
        {
            type: Twig.logic.type.endspaceless,
            regex: /^endspaceless$/,
            next: [ ],
            open: false
        },
        {
            /**
             * Macro logic tokens.
             *
             * Format: {% maro input(name, value, type, size) %}
             *
             */
            type: Twig.logic.type.macro,
            regex: /^macro\s+([a-zA-Z0-9_]+)\s*\(\s*((?:[a-zA-Z0-9_]+(?:,\s*)?)*)\s*\)$/,
            next: [
                Twig.logic.type.endmacro
            ],
            open: true,
            compile: function (token) {
                var macroName = token.match[1],
                    parameters = token.match[2].split(/[\s,]+/);

                //TODO: Clean up duplicate check
                for (var i=0; i<parameters.length; i++) {
                    for (var j=0; j<parameters.length; j++){
                        if (parameters[i] === parameters[j] && i !== j) {
                            throw new Twig.Error("Duplicate arguments for parameter: "+ parameters[i]);
                        }
                    }
                }

                token.macroName = macroName;
                token.parameters = parameters;

                delete token.match;
                return token;
            },
            parse: function (token, context, chain) {
                var template = this;
                this.macros[token.macroName] = function() {
                    // Pass global context and other macros
                    var macroContext = {
                        _self: template.macros
                    }
                    // Add parameters from context to macroContext
                    for (var i=0; i<token.parameters.length; i++) {
                        var prop = token.parameters[i];
                        if(typeof arguments[i] !== 'undefined') {
                            macroContext[prop] = arguments[i];
                        } else {
                            macroContext[prop] = undefined;
                        }
                    }
                    // Render
                    return Twig.parse.apply(template, [token.output, macroContext])
                };

                return {
                    chain: chain,
                    output: ''
                };

            }
        },
        {
            /**
             * End macro logic tokens.
             *
             * Format: {% endmacro %}
             */
             type: Twig.logic.type.endmacro,
             regex: /^endmacro$/,
             next: [ ],
             open: false
        },
        {
            /*
            * import logic tokens.
            *
            * Format: {% import "template.twig" as form %}
            */
            type: Twig.logic.type.import_,
            regex: /^import\s+(.+)\s+as\s+([a-zA-Z0-9_]+)$/,
            next: [ ],
            open: true,
            compile: function (token) {
                var expression = token.match[1].trim(),
                    contextName = token.match[2].trim();
                delete token.match;

                token.expression = expression;
                token.contextName = contextName;

                token.stack = Twig.expression.compile.apply(this, [{
                    type: Twig.expression.type.expression,
                    value: expression
                }]).stack;

                return token;
            },
            parse: function (token, context, chain) {
                if (token.expression !== "_self") {
                    var file = Twig.expression.parse.apply(this, [token.stack, context]);
                    var template = this.importFile(file || token.expression);
                    context[token.contextName] = template.render({}, {output: 'macros'});
                }
                else {
                    context[token.contextName] = this.macros;
                }

                return {
                    chain: chain,
                    output: ''
                }

            }
        },
        {
            /*
            * from logic tokens.
            *
            * Format: {% from "template.twig" import func as form %}
            */
            type: Twig.logic.type.from,
            regex: /^from\s+(.+)\s+import\s+([a-zA-Z0-9_, ]+)$/,
            next: [ ],
            open: true,
            compile: function (token) {
                var expression = token.match[1].trim(),
                    macroExpressions = token.match[2].trim().split(/[ ,]+/),
                    macroNames = {};

                for (var i=0; i<macroExpressions.length; i++) {
                    var res = macroExpressions[i];

                    // match function as variable
                    var macroMatch = res.match(/^([a-zA-Z0-9_]+)\s+(.+)\s+as\s+([a-zA-Z0-9_]+)$/);
                    if (macroMatch) {
                        macroNames[macroMatch[1].trim()] = macroMatch[2].trim();
                    }
                    else if (res.match(/^([a-zA-Z0-9_]+)$/)) {
                        macroNames[res] = res;
                    }
                    else {
                        // ignore import
                    }

                }

                delete token.match;

                token.expression = expression;
                token.macroNames = macroNames;

                token.stack = Twig.expression.compile.apply(this, [{
                    type: Twig.expression.type.expression,
                    value: expression
                }]).stack;

                return token;
            },
            parse: function (token, context, chain) {
                var macros;

                if (token.expression !== "_self") {
                    var file = Twig.expression.parse.apply(this, [token.stack, context]);
                    var template = this.importFile(file || token.expression);
                    macros = template.render({}, {output: 'macros'});
                }
                else {
                    macros = this.macros;
                }

                for (var macroName in token.macroNames) {
                    if (macros.hasOwnProperty(macroName)) {
                        context[token.macroNames[macroName]] = macros[macroName];
                    }
                }

                return {
                    chain: chain,
                    output: ''
                }

            }
        },
        {
            /**
             * The embed tag combines the behaviour of include and extends.
             * It allows you to include another template's contents, just like include does.
             *
             *  Format: {% embed "template.twig" [with {some: 'values'} only] %}
             */
            type: Twig.logic.type.embed,
            regex: /^embed\s+(ignore missing\s+)?(.+?)\s*(?:with\s+(.+?))?\s*(only)?$/,
            next: [
                Twig.logic.type.endembed
            ],
            open: true,
            compile: function (token) {
                var match = token.match,
                    includeMissing = match[1] !== undefined,
                    expression = match[2].trim(),
                    withContext = match[3],
                    only = ((match[4] !== undefined) && match[4].length);

                delete token.match;

                token.only = only;
                token.includeMissing = includeMissing;

                token.stack = Twig.expression.compile.apply(this, [{
                    type:  Twig.expression.type.expression,
                    value: expression
                }]).stack;

                if (withContext !== undefined) {
                    token.withStack = Twig.expression.compile.apply(this, [{
                        type:  Twig.expression.type.expression,
                        value: withContext.trim()
                    }]).stack;
                }

                return token;
            },
            parse: function (token, context, chain) {
                // Resolve filename
                var innerContext = {},
                    withContext,
                    i,
                    template;

                if (!token.only) {
                    for (i in context) {
                        if (context.hasOwnProperty(i))
                            innerContext[i] = context[i];
                    }
                }

                if (token.withStack !== undefined) {
                    withContext = Twig.expression.parse.apply(this, [token.withStack, context]);

                    for (i in withContext) {
                        if (withContext.hasOwnProperty(i))
                            innerContext[i] = withContext[i];
                    }
                }

                var file = Twig.expression.parse.apply(this, [token.stack, innerContext]);

                if (file instanceof Twig.Template) {
                    template = file;
                } else {
                    // Import file
                    template = this.importFile(file);
                }

                // reset previous blocks
                this.blocks = {};

                // parse tokens. output will be not used
                var output = Twig.parse.apply(this, [token.output, innerContext]);

                // render tempalte with blocks defined in embed block
                return {
                    chain: chain,
                    output: template.render(innerContext, {'blocks':this.blocks})
                };
            }
        },
        /* Add the {% endembed %} token
         *
         */
        {
            type: Twig.logic.type.endembed,
            regex: /^endembed$/,
            next: [ ],
            open: false
        }

    ];


    /**
     * Registry for logic handlers.
     */
    Twig.logic.handler = {};

    /**
     * Define a new token type, available at Twig.logic.type.{type}
     */
    Twig.logic.extendType = function (type, value) {
        value = value || ("Twig.logic.type" + type);
        Twig.logic.type[type] = value;
    };

    /**
     * Extend the logic parsing functionality with a new token definition.
     *
     * // Define a new tag
     * Twig.logic.extend({
     *     type: Twig.logic.type.{type},
     *     // The pattern to match for this token
     *     regex: ...,
     *     // What token types can follow this token, leave blank if any.
     *     next: [ ... ]
     *     // Create and return compiled version of the token
     *     compile: function(token) { ... }
     *     // Parse the compiled token with the context provided by the render call
     *     //   and whether this token chain is complete.
     *     parse: function(token, context, chain) { ... }
     * });
     *
     * @param {Object} definition The new logic expression.
     */
    Twig.logic.extend = function (definition) {

        if (!definition.type) {
            throw new Twig.Error("Unable to extend logic definition. No type provided for " + definition);
        } else {
            Twig.logic.extendType(definition.type);
        }
        Twig.logic.handler[definition.type] = definition;
    };

    // Extend with built-in expressions
    while (Twig.logic.definitions.length > 0) {
        Twig.logic.extend(Twig.logic.definitions.shift());
    }

    /**
     * Compile a logic token into an object ready for parsing.
     *
     * @param {Object} raw_token An uncompiled logic token.
     *
     * @return {Object} A compiled logic token, ready for parsing.
     */
    Twig.logic.compile = function (raw_token) {
        var expression = raw_token.value.trim(),
            token = Twig.logic.tokenize.apply(this, [expression]),
            token_template = Twig.logic.handler[token.type];

        // Check if the token needs compiling
        if (token_template.compile) {
            token = token_template.compile.apply(this, [token]);
            Twig.log.trace("Twig.logic.compile: ", "Compiled logic token to ", token);
        }

        return token;
    };

    /**
     * Tokenize logic expressions. This function matches token expressions against regular
     * expressions provided in token definitions provided with Twig.logic.extend.
     *
     * @param {string} expression the logic token expression to tokenize
     *                (i.e. what's between {% and %})
     *
     * @return {Object} The matched token with type set to the token type and match to the regex match.
     */
    Twig.logic.tokenize = function (expression) {
        var token = {},
            token_template_type = null,
            token_type = null,
            token_regex = null,
            regex_array = null,
            regex = null,
            match = null;

        // Ignore whitespace around expressions.
        expression = expression.trim();

        for (token_template_type in Twig.logic.handler) {
            if (Twig.logic.handler.hasOwnProperty(token_template_type)) {
                // Get the type and regex for this template type
                token_type = Twig.logic.handler[token_template_type].type;
                token_regex = Twig.logic.handler[token_template_type].regex;

                // Handle multiple regular expressions per type.
                regex_array = [];
                if (token_regex instanceof Array) {
                    regex_array = token_regex;
                } else {
                    regex_array.push(token_regex);
                }

                // Check regular expressions in the order they were specified in the definition.
                while (regex_array.length > 0) {
                    regex = regex_array.shift();
                    match = regex.exec(expression.trim());
                    if (match !== null) {
                        token.type  = token_type;
                        token.match = match;
                        Twig.log.trace("Twig.logic.tokenize: ", "Matched a ", token_type, " regular expression of ", match);
                        return token;
                    }
                }
            }
        }

        // No regex matches
        throw new Twig.Error("Unable to parse '" + expression.trim() + "'");
    };

    /**
     * Parse a logic token within a given context.
     *
     * What are logic chains?
     *      Logic chains represent a series of tokens that are connected,
     *          for example:
     *          {% if ... %} {% else %} {% endif %}
     *
     *      The chain parameter is used to signify if a chain is open of closed.
     *      open:
     *          More tokens in this chain should be parsed.
     *      closed:
     *          This token chain has completed parsing and any additional
     *          tokens (else, elseif, etc...) should be ignored.
     *
     * @param {Object} token The compiled token.
     * @param {Object} context The render context.
     * @param {boolean} chain Is this an open logic chain. If false, that means a
     *                        chain is closed and no further cases should be parsed.
     */
    Twig.logic.parse = function (token, context, chain) {
        var output = '',
            token_template;

        context = context || { };

        Twig.log.debug("Twig.logic.parse: ", "Parsing logic token ", token);

        token_template = Twig.logic.handler[token.type];

        if (token_template.parse) {
            output = token_template.parse.apply(this, [token, context, chain]);
        }
        return output;
    };

    return Twig;

})(Twig || { });
//     Twig.js
//     Available under the BSD 2-Clause License
//     https://github.com/justjohn/twig.js

// ## twig.expression.js
//
// This file handles tokenizing, compiling and parsing expressions.
var Twig = (function (Twig) {
    "use strict";

    /**
     * Namespace for expression handling.
     */
    Twig.expression = { };

    /**
     * Reserved word that can't be used as variable names.
     */
    Twig.expression.reservedWords = [
        "true", "false", "null", "TRUE", "FALSE", "NULL", "_context"
    ];

    /**
     * The type of tokens used in expressions.
     */
    Twig.expression.type = {
        comma:      'Twig.expression.type.comma',
        operator: {
            unary:  'Twig.expression.type.operator.unary',
            binary: 'Twig.expression.type.operator.binary'
        },
        string:     'Twig.expression.type.string',
        bool:       'Twig.expression.type.bool',
        array: {
            start:  'Twig.expression.type.array.start',
            end:    'Twig.expression.type.array.end'
        },
        object: {
            start:  'Twig.expression.type.object.start',
            end:    'Twig.expression.type.object.end'
        },
        parameter: {
            start:  'Twig.expression.type.parameter.start',
            end:    'Twig.expression.type.parameter.end'
        },
        key: {
            period:   'Twig.expression.type.key.period',
            brackets: 'Twig.expression.type.key.brackets'
        },
        filter:     'Twig.expression.type.filter',
        _function:  'Twig.expression.type._function',
        variable:   'Twig.expression.type.variable',
        number:     'Twig.expression.type.number',
        _null:     'Twig.expression.type.null',
        context:    'Twig.expression.type.context',
        test:       'Twig.expression.type.test'
    };

    Twig.expression.set = {
        // What can follow an expression (in general)
        operations: [
            Twig.expression.type.filter,
            Twig.expression.type.operator.unary,
            Twig.expression.type.operator.binary,
            Twig.expression.type.array.end,
            Twig.expression.type.object.end,
            Twig.expression.type.parameter.end,
            Twig.expression.type.comma,
            Twig.expression.type.test
        ],
        expressions: [
            Twig.expression.type._function,
            Twig.expression.type.bool,
            Twig.expression.type.string,
            Twig.expression.type.variable,
            Twig.expression.type.number,
            Twig.expression.type._null,
            Twig.expression.type.context,
            Twig.expression.type.parameter.start,
            Twig.expression.type.array.start,
            Twig.expression.type.object.start
        ]
    };

    // Most expressions allow a '.' or '[' after them, so we provide a convenience set
    Twig.expression.set.operations_extended = Twig.expression.set.operations.concat([
                    Twig.expression.type.key.period,
                    Twig.expression.type.key.brackets]);

    // Some commonly used compile and parse functions.
    Twig.expression.fn = {
        compile: {
            push: function(token, stack, output) {
                output.push(token);
            },
            push_both: function(token, stack, output) {
                output.push(token);
                stack.push(token);
            }
        },
        parse: {
            push: function(token, stack, context) {
                stack.push(token);
            },
            push_value: function(token, stack, context) {
                stack.push(token.value);
            }
        }
    };

    // The regular expressions and compile/parse logic used to match tokens in expressions.
    //
    // Properties:
    //
    //      type:  The type of expression this matches
    //
    //      regex: One or more regular expressions that matche the format of the token.
    //
    //      next:  Valid tokens that can occur next in the expression.
    //
    // Functions:
    //
    //      compile: A function that compiles the raw regular expression match into a token.
    //
    //      parse:   A function that parses the compiled token into output.
    //
    Twig.expression.definitions = [
        {
            type: Twig.expression.type.test,
            regex: /^is\s+(not)?\s*([a-zA-Z_][a-zA-Z0-9_]*)/,
            next: Twig.expression.set.operations.concat([Twig.expression.type.parameter.start]),
            compile: function(token, stack, output) {
                token.filter   = token.match[2];
                token.modifier = token.match[1];
                delete token.match;
                delete token.value;
                output.push(token);
            },
            parse: function(token, stack, context) {
                var value = stack.pop(),
                    params = token.params && Twig.expression.parse.apply(this, [token.params, context]),
                    result = Twig.test(token.filter, value, params);

                if (token.modifier == 'not') {
                    stack.push(!result);
                } else {
                    stack.push(result);
                }
            }
        },
        {
            type: Twig.expression.type.comma,
            // Match a comma
            regex: /^,/,
            next: Twig.expression.set.expressions.concat([Twig.expression.type.array.end, Twig.expression.type.object.end]),
            compile: function(token, stack, output) {
                var i = stack.length - 1,
                    stack_token;

                delete token.match;
                delete token.value;

                // pop tokens off the stack until the start of the object
                for(;i >= 0; i--) {
                    stack_token = stack.pop();
                    if (stack_token.type === Twig.expression.type.object.start
                            || stack_token.type === Twig.expression.type.parameter.start
                            || stack_token.type === Twig.expression.type.array.start) {
                        stack.push(stack_token);
                        break;
                    }
                    output.push(stack_token);
                }
                output.push(token);
            }
        },
        {
            type: Twig.expression.type.operator.binary,
            // Match any of +, *, /, -, %, ~, <, <=, >, >=, !=, ==, **, ?, :, and, or, not
            regex: /(^[\+\-~%\?\:]|^[!=]==?|^[!<>]=?|^\*\*?|^\/\/?|^and\s+|^or\s+|^in\s+|^not in\s+|^\.\.)/,
            next: Twig.expression.set.expressions.concat([Twig.expression.type.operator.unary]),
            compile: function(token, stack, output) {
                delete token.match;

                token.value = token.value.trim();
                var value = token.value,
                    operator = Twig.expression.operator.lookup(value, token);

                Twig.log.trace("Twig.expression.compile: ", "Operator: ", operator, " from ", value);

                while (stack.length > 0 &&
                       (stack[stack.length-1].type == Twig.expression.type.operator.unary || stack[stack.length-1].type == Twig.expression.type.operator.binary) &&
                            (
                                (operator.associativity === Twig.expression.operator.leftToRight &&
                                 operator.precidence    >= stack[stack.length-1].precidence) ||

                                (operator.associativity === Twig.expression.operator.rightToLeft &&
                                 operator.precidence    >  stack[stack.length-1].precidence)
                            )
                       ) {
                     var temp = stack.pop();
                     output.push(temp);
                }

                if (value === ":") {
                    // Check if this is a ternary or object key being set
                    if (stack[stack.length - 1] && stack[stack.length-1].value === "?") {
                        // Continue as normal for a ternary
                    } else {
                        // This is not a ternary so we push the token to the output where it can be handled
                        //   when the assocated object is closed.
                        var key_token = output.pop();

                        if (key_token.type === Twig.expression.type.string ||
                                key_token.type === Twig.expression.type.variable) {
                            token.key = key_token.value;
                        } else if (key_token.type === Twig.expression.type.number) {
                            // Convert integer keys into string keys
                            token.key = key_token.value.toString();
                        } else if (key_token.type === Twig.expression.type.parameter.end &&
                                key_token.expression) {
                            token.params = key_token.params;
                        } else {
                            throw new Twig.Error("Unexpected value before ':' of " + key_token.type + " = " + key_token.value);
                        }

                        output.push(token);
                        return;
                    }
                } else {
                    stack.push(operator);
                }
            },
            parse: function(token, stack, context) {
                if (token.key) {
                    // handle ternary ':' operator
                    stack.push(token);
                } else if (token.params) {
                    // handle "{(expression):value}"
                    token.key = Twig.expression.parse.apply(this, [token.params, context]);
                    stack.push(token);
                    delete(token.params);
                } else {
                    Twig.expression.operator.parse(token.value, stack);
                }
            }
        },
        {
            type: Twig.expression.type.operator.unary,
            // Match any of not
            regex: /(^not\s+)/,
            next: Twig.expression.set.expressions,
            compile: function(token, stack, output) {
                delete token.match;

                token.value = token.value.trim();
                var value = token.value,
                    operator = Twig.expression.operator.lookup(value, token);

                Twig.log.trace("Twig.expression.compile: ", "Operator: ", operator, " from ", value);

                while (stack.length > 0 &&
                       (stack[stack.length-1].type == Twig.expression.type.operator.unary || stack[stack.length-1].type == Twig.expression.type.operator.binary) &&
                            (
                                (operator.associativity === Twig.expression.operator.leftToRight &&
                                 operator.precidence    >= stack[stack.length-1].precidence) ||

                                (operator.associativity === Twig.expression.operator.rightToLeft &&
                                 operator.precidence    >  stack[stack.length-1].precidence)
                            )
                       ) {
                     var temp = stack.pop();
                     output.push(temp);
                }

                stack.push(operator);
            },
            parse: function(token, stack, context) {
                Twig.expression.operator.parse(token.value, stack);
            }
        },
        {
            /**
             * Match a string. This is anything between a pair of single or double quotes.
             */
            type: Twig.expression.type.string,
            // See: http://blog.stevenlevithan.com/archives/match-quoted-string
            regex: /^(["'])(?:(?=(\\?))\2[\s\S])*?\1/,
            next: Twig.expression.set.operations,
            compile: function(token, stack, output) {
                var value = token.value;
                delete token.match

                // Remove the quotes from the string
                if (value.substring(0, 1) === '"') {
                    value = value.replace('\\"', '"');
                } else {
                    value = value.replace("\\'", "'");
                }
                token.value = value.substring(1, value.length-1).replace( /\\n/g, "\n" ).replace( /\\r/g, "\r" );
                Twig.log.trace("Twig.expression.compile: ", "String value: ", token.value);
                output.push(token);
            },
            parse: Twig.expression.fn.parse.push_value
        },
        {
            /**
             * Match a parameter set start.
             */
            type: Twig.expression.type.parameter.start,
            regex: /^\(/,
            next: Twig.expression.set.expressions.concat([Twig.expression.type.parameter.end]),
            compile: Twig.expression.fn.compile.push_both,
            parse: Twig.expression.fn.parse.push
        },
        {
            /**
             * Match a parameter set end.
             */
            type: Twig.expression.type.parameter.end,
            regex: /^\)/,
            next: Twig.expression.set.operations_extended,
            compile: function(token, stack, output) {
                var stack_token,
                    end_token = token;

                stack_token = stack.pop();
                while(stack.length > 0 && stack_token.type != Twig.expression.type.parameter.start) {
                    output.push(stack_token);
                    stack_token = stack.pop();
                }

                // Move contents of parens into preceding filter
                var param_stack = [];
                while(token.type !== Twig.expression.type.parameter.start) {
                    // Add token to arguments stack
                    param_stack.unshift(token);
                    token = output.pop();
                }
                param_stack.unshift(token);

                var is_expression = false;

                // Get the token preceding the parameters
                token = output[output.length-1];

                if (token === undefined ||
                    (token.type !== Twig.expression.type._function &&
                    token.type !== Twig.expression.type.filter &&
                    token.type !== Twig.expression.type.test &&
                    token.type !== Twig.expression.type.key.brackets &&
                    token.type !== Twig.expression.type.key.period)) {

                    end_token.expression = true;

                    // remove start and end token from stack
                    param_stack.pop();
                    param_stack.shift();

                    end_token.params = param_stack;

                    output.push(end_token);

                } else {
                    end_token.expression = false;
                    token.params = param_stack;
                }
            },
            parse: function(token, stack, context) {
                var new_array = [],
                    array_ended = false,
                    value = null;

                if (token.expression) {
                    value = Twig.expression.parse.apply(this, [token.params, context])
                    stack.push(value);

                } else {

                    while (stack.length > 0) {
                        value = stack.pop();
                        // Push values into the array until the start of the array
                        if (value && value.type && value.type == Twig.expression.type.parameter.start) {
                            array_ended = true;
                            break;
                        }
                        new_array.unshift(value);
                    }

                    if (!array_ended) {
                        throw new Twig.Error("Expected end of parameter set.");
                    }

                    stack.push(new_array);
                }
            }
        },
        {
            /**
             * Match an array start.
             */
            type: Twig.expression.type.array.start,
            regex: /^\[/,
            next: Twig.expression.set.expressions.concat([Twig.expression.type.array.end]),
            compile: Twig.expression.fn.compile.push_both,
            parse: Twig.expression.fn.parse.push
        },
        {
            /**
             * Match an array end.
             */
            type: Twig.expression.type.array.end,
            regex: /^\]/,
            next: Twig.expression.set.operations_extended,
            compile: function(token, stack, output) {
                var i = stack.length - 1,
                    stack_token;
                // pop tokens off the stack until the start of the object
                for(;i >= 0; i--) {
                    stack_token = stack.pop();
                    if (stack_token.type === Twig.expression.type.array.start) {
                        break;
                    }
                    output.push(stack_token);
                }
                output.push(token);
            },
            parse: function(token, stack, context) {
                var new_array = [],
                    array_ended = false,
                    value = null;

                while (stack.length > 0) {
                    value = stack.pop();
                    // Push values into the array until the start of the array
                    if (value.type && value.type == Twig.expression.type.array.start) {
                        array_ended = true;
                        break;
                    }
                    new_array.unshift(value);
                }
                if (!array_ended) {
                    throw new Twig.Error("Expected end of array.");
                }

                stack.push(new_array);
            }
        },
        // Token that represents the start of a hash map '}'
        //
        // Hash maps take the form:
        //    { "key": 'value', "another_key": item }
        //
        // Keys must be quoted (either single or double) and values can be any expression.
        {
            type: Twig.expression.type.object.start,
            regex: /^\{/,
            next: Twig.expression.set.expressions.concat([Twig.expression.type.object.end]),
            compile: Twig.expression.fn.compile.push_both,
            parse: Twig.expression.fn.parse.push
        },

        // Token that represents the end of a Hash Map '}'
        //
        // This is where the logic for building the internal
        // representation of a hash map is defined.
        {
            type: Twig.expression.type.object.end,
            regex: /^\}/,
            next: Twig.expression.set.operations_extended,
            compile: function(token, stack, output) {
                var i = stack.length-1,
                    stack_token;

                // pop tokens off the stack until the start of the object
                for(;i >= 0; i--) {
                    stack_token = stack.pop();
                    if (stack_token && stack_token.type === Twig.expression.type.object.start) {
                        break;
                    }
                    output.push(stack_token);
                }
                output.push(token);
            },
            parse: function(end_token, stack, context) {
                var new_object = {},
                    object_ended = false,
                    token = null,
                    token_key = null,
                    has_value = false,
                    value = null;

                while (stack.length > 0) {
                    token = stack.pop();
                    // Push values into the array until the start of the object
                    if (token && token.type && token.type === Twig.expression.type.object.start) {
                        object_ended = true;
                        break;
                    }
                    if (token && token.type && (token.type === Twig.expression.type.operator.binary || token.type === Twig.expression.type.operator.unary) && token.key) {
                        if (!has_value) {
                            throw new Twig.Error("Missing value for key '" + token.key + "' in object definition.");
                        }
                        new_object[token.key] = value;

                        // Preserve the order that elements are added to the map
                        // This is necessary since JavaScript objects don't
                        // guarantee the order of keys
                        if (new_object._keys === undefined) new_object._keys = [];
                        new_object._keys.unshift(token.key);

                        // reset value check
                        value = null;
                        has_value = false;

                    } else {
                        has_value = true;
                        value = token;
                    }
                }
                if (!object_ended) {
                    throw new Twig.Error("Unexpected end of object.");
                }

                stack.push(new_object);
            }
        },

        // Token representing a filter
        //
        // Filters can follow any expression and take the form:
        //    expression|filter(optional, args)
        //
        // Filter parsing is done in the Twig.filters namespace.
        {
            type: Twig.expression.type.filter,
            // match a | then a letter or _, then any number of letters, numbers, _ or -
            regex: /^\|\s?([a-zA-Z_][a-zA-Z0-9_\-]*)/,
            next: Twig.expression.set.operations_extended.concat([
                    Twig.expression.type.parameter.start]),
            compile: function(token, stack, output) {
                token.value = token.match[1];
                output.push(token);
            },
            parse: function(token, stack, context) {
                var input = stack.pop(),
                    params = token.params && Twig.expression.parse.apply(this, [token.params, context]);

                stack.push(Twig.filter.apply(this, [token.value, input, params]));
            }
        },
        {
            type: Twig.expression.type._function,
            // match any letter or _, then any number of letters, numbers, _ or - followed by (
            regex: /^([a-zA-Z_][a-zA-Z0-9_]*)\s*\(/,
            next: Twig.expression.type.parameter.start,
            transform: function(match, tokens) {
                return '(';
            },
            compile: function(token, stack, output) {
                var fn = token.match[1];
                token.fn = fn;
                // cleanup token
                delete token.match;
                delete token.value;

                output.push(token);
            },
            parse: function(token, stack, context) {
                var params = token.params && Twig.expression.parse.apply(this, [token.params, context]),
                    fn     = token.fn,
                    value;

                if (Twig.functions[fn]) {
                    // Get the function from the built-in functions
                    value = Twig.functions[fn].apply(this, params);

                } else if (typeof context[fn] == 'function') {
                    // Get the function from the user/context defined functions
                    value = context[fn].apply(context, params);

                } else {
                    throw new Twig.Error(fn + ' function does not exist and is not defined in the context');
                }

                stack.push(value);
            }
        },

        // Token representing a variable.
        //
        // Variables can contain letters, numbers, underscores and
        // dashes, but must start with a letter or underscore.
        //
        // Variables are retrieved from the render context and take
        // the value of 'undefined' if the given variable doesn't
        // exist in the context.
        {
            type: Twig.expression.type.variable,
            // match any letter or _, then any number of letters, numbers, _ or -
            regex: /^[a-zA-Z_][a-zA-Z0-9_]*/,
            next: Twig.expression.set.operations_extended.concat([
                    Twig.expression.type.parameter.start]),
            compile: Twig.expression.fn.compile.push,
            validate: function(match, tokens) {
                return (Twig.indexOf(Twig.expression.reservedWords, match[0]) < 0);
            },
            parse: function(token, stack, context) {
                // Get the variable from the context
                var value = Twig.expression.resolve(context[token.value], context);
                stack.push(value);
            }
        },
        {
            type: Twig.expression.type.key.period,
            regex: /^\.([a-zA-Z0-9_]+)/,
            next: Twig.expression.set.operations_extended.concat([
                    Twig.expression.type.parameter.start]),
            compile: function(token, stack, output) {
                token.key = token.match[1];
                delete token.match;
                delete token.value;

                output.push(token);
            },
            parse: function(token, stack, context) {
                var params = token.params && Twig.expression.parse.apply(this, [token.params, context]),
                    key = token.key,
                    object = stack.pop(),
                    value;

                if (object === null || object === undefined) {
                    if (this.options.strict_variables) {
                        throw new Twig.Error("Can't access a key " + key + " on an null or undefined object.");
                    } else {
                        return null;
                    }
                }

                var capitalize = function(value) {return value.substr(0, 1).toUpperCase() + value.substr(1);};

                // Get the variable from the context
                if (typeof object === 'object' && key in object) {
                    value = object[key];
                } else if (object["get"+capitalize(key)] !== undefined) {
                    value = object["get"+capitalize(key)];
                } else if (object["is"+capitalize(key)] !== undefined) {
                    value = object["is"+capitalize(key)];
                } else {
                    value = undefined;
                }
                stack.push(Twig.expression.resolve(value, object, params));
            }
        },
        {
            type: Twig.expression.type.key.brackets,
            regex: /^\[([^\]]*)\]/,
            next: Twig.expression.set.operations_extended.concat([
                    Twig.expression.type.parameter.start]),
            compile: function(token, stack, output) {
                var match = token.match[1];
                delete token.value;
                delete token.match;

                // The expression stack for the key
                token.stack = Twig.expression.compile({
                    value: match
                }).stack;

                output.push(token);
            },
            parse: function(token, stack, context) {
                // Evaluate key
                var params = token.params && Twig.expression.parse.apply(this, [token.params, context]),
                    key = Twig.expression.parse.apply(this, [token.stack, context]),
                    object = stack.pop(),
                    value;

                if (object === null || object === undefined) {
                    if (this.options.strict_variables) {
                        throw new Twig.Error("Can't access a key " + key + " on an null or undefined object.");
                    } else {
                        return null;
                    }
                }

                // Get the variable from the context
                if (typeof object === 'object' && key in object) {
                    value = object[key];
                } else {
                    value = null;
                }
                stack.push(Twig.expression.resolve(value, object, params));
            }
        },
        {
            /**
             * Match a null value.
             */
            type: Twig.expression.type._null,
            // match a number
            regex: /^(null|NULL|none|NONE)/,
            next: Twig.expression.set.operations,
            compile: function(token, stack, output) {
                delete token.match;
                token.value = null;
                output.push(token);
            },
            parse: Twig.expression.fn.parse.push_value
        },
        {
            /**
             * Match the context
             */
            type: Twig.expression.type.context,
            regex: /^_context/,
            next: Twig.expression.set.operations_extended.concat([
                    Twig.expression.type.parameter.start]),
            compile: Twig.expression.fn.compile.push,
            parse: function(token, stack, context) {
                stack.push(context);
            }
        },
        {
            /**
             * Match a number (integer or decimal)
             */
            type: Twig.expression.type.number,
            // match a number
            regex: /^\-?\d+(\.\d+)?/,
            next: Twig.expression.set.operations,
            compile: function(token, stack, output) {
                token.value = Number(token.value);
                output.push(token);
            },
            parse: Twig.expression.fn.parse.push_value
        },
        {
            /**
             * Match a boolean
             */
            type: Twig.expression.type.bool,
            regex: /^(true|TRUE|false|FALSE)/,
            next: Twig.expression.set.operations,
            compile: function(token, stack, output) {
                token.value = (token.match[0].toLowerCase( ) === "true");
                delete token.match;
                output.push(token);
            },
            parse: Twig.expression.fn.parse.push_value
        }
    ];

    /**
     * Resolve a context value.
     *
     * If the value is a function, it is executed with a context parameter.
     *
     * @param {string} key The context object key.
     * @param {Object} context The render context.
     */
    Twig.expression.resolve = function(value, context, params) {
        if (typeof value == 'function') {
            return value.apply(context, params || []);
        } else {
            return value;
        }
    };

    /**
     * Registry for logic handlers.
     */
    Twig.expression.handler = {};

    /**
     * Define a new expression type, available at Twig.logic.type.{type}
     *
     * @param {string} type The name of the new type.
     */
    Twig.expression.extendType = function (type) {
        Twig.expression.type[type] = "Twig.expression.type." + type;
    };

    /**
     * Extend the expression parsing functionality with a new definition.
     *
     * Token definitions follow this format:
     *  {
     *      type:     One of Twig.expression.type.[type], either pre-defined or added using
     *                    Twig.expression.extendType
     *
     *      next:     Array of types from Twig.expression.type that can follow this token,
     *
     *      regex:    A regex or array of regex's that should match the token.
     *
     *      compile: function(token, stack, output) called when this token is being compiled.
     *                   Should return an object with stack and output set.
     *
     *      parse:   function(token, stack, context) called when this token is being parsed.
     *                   Should return an object with stack and context set.
     *  }
     *
     * @param {Object} definition A token definition.
     */
    Twig.expression.extend = function (definition) {
        if (!definition.type) {
            throw new Twig.Error("Unable to extend logic definition. No type provided for " + definition);
        }
        Twig.expression.handler[definition.type] = definition;
    };

    // Extend with built-in expressions
    while (Twig.expression.definitions.length > 0) {
        Twig.expression.extend(Twig.expression.definitions.shift());
    }

    /**
     * Break an expression into tokens defined in Twig.expression.definitions.
     *
     * @param {string} expression The string to tokenize.
     *
     * @return {Array} An array of tokens.
     */
    Twig.expression.tokenize = function (expression) {
        var tokens = [],
            // Keep an offset of the location in the expression for error messages.
            exp_offset = 0,
            // The valid next tokens of the previous token
            next = null,
            // Match information
            type, regex, regex_array,
            // The possible next token for the match
            token_next,
            // Has a match been found from the definitions
            match_found, invalid_matches = [], match_function;

        match_function = function () {
            var match = Array.prototype.slice.apply(arguments),
                string = match.pop(),
                offset = match.pop();

            Twig.log.trace("Twig.expression.tokenize",
                           "Matched a ", type, " regular expression of ", match);

            if (next && Twig.indexOf(next, type) < 0) {
                invalid_matches.push(
                    type + " cannot follow a " + tokens[tokens.length - 1].type +
                           " at template:" + exp_offset + " near '" + match[0].substring(0, 20) +
                           "...'"
                );
                // Not a match, don't change the expression
                return match[0];
            }

            // Validate the token if a validation function is provided
            if (Twig.expression.handler[type].validate &&
                    !Twig.expression.handler[type].validate(match, tokens)) {
                return match[0];
            }

            invalid_matches = [];

            tokens.push({
                type:  type,
                value: match[0],
                match: match
            });

            match_found = true;
            next = token_next;
            exp_offset += match[0].length;

            // Does the token need to return output back to the expression string
            // e.g. a function match of cycle( might return the '(' back to the expression
            // This allows look-ahead to differentiate between token types (e.g. functions and variable names)
            if (Twig.expression.handler[type].transform) {
                return Twig.expression.handler[type].transform(match, tokens);
            }
            return '';
        };

        Twig.log.debug("Twig.expression.tokenize", "Tokenizing expression ", expression);

        while (expression.length > 0) {
            expression = expression.trim();
            for (type in Twig.expression.handler) {
                if (Twig.expression.handler.hasOwnProperty(type)) {
                    token_next = Twig.expression.handler[type].next;
                    regex = Twig.expression.handler[type].regex;
                    // Twig.log.trace("Checking type ", type, " on ", expression);
                    if (regex instanceof Array) {
                        regex_array = regex;
                    } else {
                        regex_array = [regex];
                    }

                    match_found = false;
                    while (regex_array.length > 0) {
                        regex = regex_array.pop();
                        expression = expression.replace(regex, match_function);
                    }
                    // An expression token has been matched. Break the for loop and start trying to
                    //  match the next template (if expression isn't empty.)
                    if (match_found) {
                        break;
                    }
                }
            }
            if (!match_found) {
                if (invalid_matches.length > 0) {
                    throw new Twig.Error(invalid_matches.join(" OR "));
                } else {
                    throw new Twig.Error("Unable to parse '" + expression + "' at template position" + exp_offset);
                }
            }
        }

        Twig.log.trace("Twig.expression.tokenize", "Tokenized to ", tokens);
        return tokens;
    };

    /**
     * Compile an expression token.
     *
     * @param {Object} raw_token The uncompiled token.
     *
     * @return {Object} The compiled token.
     */
    Twig.expression.compile = function (raw_token) {
        var expression = raw_token.value,
            // Tokenize expression
            tokens = Twig.expression.tokenize(expression),
            token = null,
            output = [],
            stack = [],
            token_template = null;

        Twig.log.trace("Twig.expression.compile: ", "Compiling ", expression);

        // Push tokens into RPN stack using the Sunting-yard algorithm
        // See http://en.wikipedia.org/wiki/Shunting_yard_algorithm

        while (tokens.length > 0) {
            token = tokens.shift();
            token_template = Twig.expression.handler[token.type];

            Twig.log.trace("Twig.expression.compile: ", "Compiling ", token);

            // Compile the template
            token_template.compile && token_template.compile(token, stack, output);

            Twig.log.trace("Twig.expression.compile: ", "Stack is", stack);
            Twig.log.trace("Twig.expression.compile: ", "Output is", output);
        }

        while(stack.length > 0) {
            output.push(stack.pop());
        }

        Twig.log.trace("Twig.expression.compile: ", "Final output is", output);

        raw_token.stack = output;
        delete raw_token.value;

        return raw_token;
    };


    /**
     * Parse an RPN expression stack within a context.
     *
     * @param {Array} tokens An array of compiled expression tokens.
     * @param {Object} context The render context to parse the tokens with.
     *
     * @return {Object} The result of parsing all the tokens. The result
     *                  can be anything, String, Array, Object, etc... based on
     *                  the given expression.
     */
    Twig.expression.parse = function (tokens, context) {
        var that = this;

        // If the token isn't an array, make it one.
        if (!(tokens instanceof Array)) {
            tokens = [tokens];
        }

        // The output stack
        var stack = [],
            token_template = null;

        Twig.forEach(tokens, function (token) {
            token_template = Twig.expression.handler[token.type];

            token_template.parse && token_template.parse.apply(that, [token, stack, context]);
        });

        // Pop the final value off the stack
        return stack.pop();
    };

    return Twig;

})( Twig || { } );
//     Twig.js
//     Available under the BSD 2-Clause License
//     https://github.com/justjohn/twig.js

// ## twig.expression.operator.js
//
// This file handles operator lookups and parsing.
var Twig = (function (Twig) {
    "use strict";

    /**
     * Operator associativity constants.
     */
    Twig.expression.operator = {
        leftToRight: 'leftToRight',
        rightToLeft: 'rightToLeft'
    };

    var containment = function(a, b) {
        if (b === undefined || b === null) {
            return null;
        } else if (b.indexOf !== undefined) {
            // String
            return a === b || a !== '' && b.indexOf(a) > -1;
        } else {
            var el;
            for (el in b) {
                if (b.hasOwnProperty(el) && b[el] === a) {
                    return true;
                }
            }
            return false;
        }
    };

    /**
     * Get the precidence and associativity of an operator. These follow the order that C/C++ use.
     * See http://en.wikipedia.org/wiki/Operators_in_C_and_C++ for the table of values.
     */
    Twig.expression.operator.lookup = function (operator, token) {
        switch (operator) {
            case "..":
            case 'not in':
            case 'in':
                token.precidence = 20;
                token.associativity = Twig.expression.operator.leftToRight;
                break;

            case ',':
                token.precidence = 18;
                token.associativity = Twig.expression.operator.leftToRight;
                break;

            // Ternary
            case '?':
            case ':':
                token.precidence = 16;
                token.associativity = Twig.expression.operator.rightToLeft;
                break;

            case 'or':
                token.precidence = 14;
                token.associativity = Twig.expression.operator.leftToRight;
                break;

            case 'and':
                token.precidence = 13;
                token.associativity = Twig.expression.operator.leftToRight;
                break;

            case '==':
            case '!=':
                token.precidence = 9;
                token.associativity = Twig.expression.operator.leftToRight;
                break;

            case '<':
            case '<=':
            case '>':
            case '>=':
                token.precidence = 8;
                token.associativity = Twig.expression.operator.leftToRight;
                break;


            case '~': // String concatination
            case '+':
            case '-':
                token.precidence = 6;
                token.associativity = Twig.expression.operator.leftToRight;
                break;

            case '//':
            case '**':
            case '*':
            case '/':
            case '%':
                token.precidence = 5;
                token.associativity = Twig.expression.operator.leftToRight;
                break;

            case 'not':
                token.precidence = 3;
                token.associativity = Twig.expression.operator.rightToLeft;
                break;

            default:
                throw new Twig.Error(operator + " is an unknown operator.");
        }
        token.operator = operator;
        return token;
    };

    /**
     * Handle operations on the RPN stack.
     *
     * Returns the updated stack.
     */
    Twig.expression.operator.parse = function (operator, stack) {
        Twig.log.trace("Twig.expression.operator.parse: ", "Handling ", operator);
        var a, b, c;
        switch (operator) {
            case ':':
                // Ignore
                break;

            case '?':
                c = stack.pop(); // false expr
                b = stack.pop(); // true expr
                a = stack.pop(); // conditional
                if (a) {
                    stack.push(b);
                } else {
                    stack.push(c);
                }
                break;

            case '+':
                b = parseFloat(stack.pop());
                a = parseFloat(stack.pop());
                stack.push(a + b);
                break;

            case '-':
                b = parseFloat(stack.pop());
                a = parseFloat(stack.pop());
                stack.push(a - b);
                break;

            case '*':
                b = parseFloat(stack.pop());
                a = parseFloat(stack.pop());
                stack.push(a * b);
                break;

            case '/':
                b = parseFloat(stack.pop());
                a = parseFloat(stack.pop());
                stack.push(a / b);
                break;

            case '//':
                b = parseFloat(stack.pop());
                a = parseFloat(stack.pop());
                stack.push(parseInt(a / b));
                break;

            case '%':
                b = parseFloat(stack.pop());
                a = parseFloat(stack.pop());
                stack.push(a % b);
                break;

            case '~':
                b = stack.pop();
                a = stack.pop();
                stack.push( (a != null ? a.toString() : "")
                          + (b != null ? b.toString() : "") );
                break;

            case 'not':
            case '!':
                stack.push(!stack.pop());
                break;

            case '<':
                b = stack.pop();
                a = stack.pop();
                stack.push(a < b);
                break;

            case '<=':
                b = stack.pop();
                a = stack.pop();
                stack.push(a <= b);
                break;

            case '>':
                b = stack.pop();
                a = stack.pop();
                stack.push(a > b);
                break;

            case '>=':
                b = stack.pop();
                a = stack.pop();
                stack.push(a >= b);
                break;

            case '===':
                b = stack.pop();
                a = stack.pop();
                stack.push(a === b);
                break;

            case '==':
                b = stack.pop();
                a = stack.pop();
                stack.push(a == b);
                break;

            case '!==':
                b = stack.pop();
                a = stack.pop();
                stack.push(a !== b);
                break;

            case '!=':
                b = stack.pop();
                a = stack.pop();
                stack.push(a != b);
                break;

            case 'or':
                b = stack.pop();
                a = stack.pop();
                stack.push(a || b);
                break;

            case 'and':
                b = stack.pop();
                a = stack.pop();
                stack.push(a && b);
                break;

            case '**':
                b = stack.pop();
                a = stack.pop();
                stack.push(Math.pow(a, b));
                break;


            case 'not in':
                b = stack.pop();
                a = stack.pop();
                stack.push( !containment(a, b) );
                break;

            case 'in':
                b = stack.pop();
                a = stack.pop();
                stack.push( containment(a, b) );
                break;

            case '..':
                b = stack.pop();
                a = stack.pop();
                stack.push( Twig.functions.range(a, b) );
                break;

            default:
                throw new Twig.Error(operator + " is an unknown operator.");
        }
    };

    return Twig;

})( Twig || { } );
//     Twig.js
//     Available under the BSD 2-Clause License
//     https://github.com/justjohn/twig.js

// ## twig.filters.js
//
// This file handles parsing filters.
var Twig = (function (Twig) {

    // Determine object type
    function is(type, obj) {
        var clas = Object.prototype.toString.call(obj).slice(8, -1);
        return obj !== undefined && obj !== null && clas === type;
    }

    Twig.filters = {
        // String Filters
        upper:  function(value) {
            if ( typeof value !== "string" ) {
               return value;
            }

            return value.toUpperCase();
        },
        lower: function(value) {
            if ( typeof value !== "string" ) {
               return value;
            }

            return value.toLowerCase();
        },
        capitalize: function(value) {
            if ( typeof value !== "string" ) {
                 return value;
            }

            return value.substr(0, 1).toUpperCase() + value.toLowerCase().substr(1);
        },
        title: function(value) {
            if ( typeof value !== "string" ) {
               return value;
            }

            return value.toLowerCase().replace( /(^|\s)([a-z])/g , function(m, p1, p2){
                return p1 + p2.toUpperCase();
            });
        },
        length: function(value) {
            if (Twig.lib.is("Array", value) || typeof value === "string") {
                return value.length;
            } else if (Twig.lib.is("Object", value)) {
                if (value._keys === undefined) {
                    return Object.keys(value).length;
                } else {
                    return value._keys.length;
                }
            } else {
                return 0;
            }
        },

        // Array/Object Filters
        reverse: function(value) {
            if (is("Array", value)) {
                return value.reverse();
            } else if (is("String", value)) {
                return value.split("").reverse().join("");
            } else if (is("Object", value)) {
                var keys = value._keys || Object.keys(value).reverse();
                value._keys = keys;
                return value;
            }
        },
        sort: function(value) {
            if (is("Array", value)) {
                return value.sort();
            } else if (is('Object', value)) {
                // Sorting objects isn't obvious since the order of
                // returned keys isn't guaranteed in JavaScript.
                // Because of this we use a "hidden" key called _keys to
                // store the keys in the order we want to return them.

                delete value._keys;
                var keys = Object.keys(value),
                    sorted_keys = keys.sort(function(a, b) {
                        var a1, a2;

                        // if a and b are comparable, we're fine :-)
                        if((value[a] > value[b]) == !(value[a] <= value[b])) {
                            return value[a] > value[b] ? 1 :
			           value[a] < value[b] ? -1 :
				   0;
                        }
                        // if a and b can be parsed as numbers, we can compare
                        // their numeric value
                        else if(!isNaN(a1 = parseFloat(value[a])) &&
                                !isNaN(b1 = parseFloat(value[b]))) {
                            return a1 > b1 ? 1 :
			           a1 < b1 ? -1 :
				   0;
                        }
                        // if one of the values is a string, we convert the
                        // other value to string as well
                        else if(typeof value[a] == 'string') {
                            return value[a] > value[b].toString() ? 1 :
                                   value[a] < value[b].toString() ? -1 :
				   0;
                        }
                        else if(typeof value[b] == 'string') {
                            return value[a].toString() > value[b] ? 1 :
                                   value[a].toString() < value[b] ? -1 :
				   0;
                        }
                        // everything failed - return 'null' as sign, that
                        // the values are not comparable
                        else {
                            return null;
                        }
                    });
                value._keys = sorted_keys;
                return value;
            }
        },
        keys: function(value) {
            if (value === undefined || value === null){
                return;
           }

            var keyset = value._keys || Object.keys(value),
                output = [];

            Twig.forEach(keyset, function(key) {
                if (key === "_keys") return; // Ignore the _keys property
                if (value.hasOwnProperty(key)) {
                    output.push(key);
                }
            });
            return output;
        },
        url_encode: function(value) {
            if (value === undefined || value === null){
                return;
            }

            var result = encodeURIComponent(value);
            result = result.replace("'", "%27");
            return result;
        },
        join: function(value, params) {
            if (value === undefined || value === null){
                return;
            }

            var join_str = "",
                output = [],
                keyset = null;

            if (params && params[0]) {
                join_str = params[0];
            }
            if (is("Array", value)) {
                output = value;
            } else {
                keyset = value._keys || Object.keys(value);
                Twig.forEach(keyset, function(key) {
                    if (key === "_keys") return; // Ignore the _keys property
                    if (value.hasOwnProperty(key)) {
                        output.push(value[key]);
                    }
                });
            }
            return output.join(join_str);
        },
        "default": function(value, params) {
            if (params !== undefined && params.length > 1) {
                throw new Twig.Error("default filter expects one argument");
            }
            if (value === undefined || value === null || value === '' ) {
                if (params === undefined) {
                    return '';
                }

                return params[0];
            } else {
                return value;
            }
        },
        json_encode: function(value) {
            if(value === undefined || value === null) {
                return "null";
            }
            else if ((typeof value == 'object') && (is("Array", value))) {
                output = [];

                Twig.forEach(value, function(v) {
                    output.push(Twig.filters.json_encode(v));
                });

                return "[" + output.join(",") + "]";
            }
            else if (typeof value == 'object') {
                var keyset = value._keys || Object.keys(value),
                output = [];

                Twig.forEach(keyset, function(key) {
                    output.push(JSON.stringify(key) + ":" + Twig.filters.json_encode(value[key]));
                });

                return "{" + output.join(",") + "}";
            }
            else {
                return JSON.stringify(value);
            }
        },
        merge: function(value, params) {
            var obj = [],
                arr_index = 0,
                keyset = [];

            // Check to see if all the objects being merged are arrays
            if (!is("Array", value)) {
                // Create obj as an Object
                obj = { };
            } else {
                Twig.forEach(params, function(param) {
                    if (!is("Array", param)) {
                        obj = { };
                    }
                });
            }
            if (!is("Array", obj)) {
                obj._keys = [];
            }

            if (is("Array", value)) {
                Twig.forEach(value, function(val) {
                    if (obj._keys) obj._keys.push(arr_index);
                    obj[arr_index] = val;
                    arr_index++;
                });
            } else {
                keyset = value._keys || Object.keys(value);
                Twig.forEach(keyset, function(key) {
                    obj[key] = value[key];
                    obj._keys.push(key);

                    // Handle edge case where a number index in an object is greater than
                    //   the array counter. In such a case, the array counter is increased
                    //   one past the index.
                    //
                    // Example {{ ["a", "b"]|merge({"4":"value"}, ["c", "d"])
                    // Without this, d would have an index of "4" and overwrite the value
                    //   of "value"
                    var int_key = parseInt(key, 10);
                    if (!isNaN(int_key) && int_key >= arr_index) {
                        arr_index = int_key + 1;
                    }
                });
            }

            // mixin the merge arrays
            Twig.forEach(params, function(param) {
                if (is("Array", param)) {
                    Twig.forEach(param, function(val) {
                        if (obj._keys) obj._keys.push(arr_index);
                        obj[arr_index] = val;
                        arr_index++;
                    });
                } else {
                    keyset = param._keys || Object.keys(param);
                    Twig.forEach(keyset, function(key) {
                        if (!obj[key]) obj._keys.push(key);
                        obj[key] = param[key];

                        var int_key = parseInt(key, 10);
                        if (!isNaN(int_key) && int_key >= arr_index) {
                            arr_index = int_key + 1;
                        }
                    });
                }
            });
            if (params.length === 0) {
                throw new Twig.Error("Filter merge expects at least one parameter");
            }

            return obj;
        },
        date: function(value, params) {
            var date = Twig.functions.date(value);
            var format = params && params.length ? params[0] : 'F j, Y H:i';
            return Twig.lib.formatDate(date, format);
        },

        date_modify: function(value, params) {
            if (value === undefined || value === null) {
                return;
            }
            if (params === undefined || params.length !== 1) {
                throw new Twig.Error("date_modify filter expects 1 argument");
            }

            var modifyText = params[0], time;

            if (Twig.lib.is("Date", value)) {
                time = Twig.lib.strtotime(modifyText, value.getTime() / 1000);
            }
            if (Twig.lib.is("String", value)) {
                time = Twig.lib.strtotime(modifyText, Twig.lib.strtotime(value));
            }
            if (Twig.lib.is("Number", value)) {
                time = Twig.lib.strtotime(modifyText, value);
            }

            return new Date(time * 1000);
        },

        replace: function(value, params) {
            if (value === undefined||value === null){
                return;
            }

            var pairs = params[0],
                tag;
            for (tag in pairs) {
                if (pairs.hasOwnProperty(tag) && tag !== "_keys") {
                    value = Twig.lib.replaceAll(value, tag, pairs[tag]);
                }
            }
            return value;
        },

        format: function(value, params) {
            if (value === undefined || value === null){
                return;
            }

            return Twig.lib.vsprintf(value, params);
        },

        striptags: function(value) {
            if (value === undefined || value === null){
                return;
            }

            return Twig.lib.strip_tags(value);
        },

        escape: function(value, params) {
            if (value === undefined|| value === null){
                return;
            }

            var strategy = "html";
            if(params && params.length && params[0] !== true)
                strategy = params[0];

            if(strategy == "html") {
                var raw_value = value.toString().replace(/&/g, "&amp;")
                            .replace(/</g, "&lt;")
                            .replace(/>/g, "&gt;")
                            .replace(/"/g, "&quot;")
                            .replace(/'/g, "&#039;");
                return Twig.Markup(raw_value, 'html');
            } else if(strategy == "js") {
                var raw_value = value.toString();
                var result = "";

                for(var i = 0; i < raw_value.length; i++) {
                    if(raw_value[i].match(/^[a-zA-Z0-9,\._]$/))
                        result += raw_value[i];
                    else {
                        var char_code = raw_value.charCodeAt(i);

                        if(char_code < 0x80)
                            result += "\\x" + char_code.toString(16).toUpperCase();
                        else
                            result += Twig.lib.sprintf("\\u%04s", char_code.toString(16).toUpperCase());
                    }
                }

                return Twig.Markup(result, 'js');
            } else if(strategy == "css") {
                var raw_value = value.toString();
                var result = "";

                for(var i = 0; i < raw_value.length; i++) {
                    if(raw_value[i].match(/^[a-zA-Z0-9]$/))
                        result += raw_value[i];
                    else {
                        var char_code = raw_value.charCodeAt(i);
                        result += "\\" + char_code.toString(16).toUpperCase() + " ";
                    }
                }

                return Twig.Markup(result, 'css');
            } else if(strategy == "url") {
                var result = Twig.filters.url_encode(value);
                return Twig.Markup(result, 'url');
            } else if(strategy == "html_attr") {
                var raw_value = value.toString();
                var result = "";

                for(var i = 0; i < raw_value.length; i++) {
                    if(raw_value[i].match(/^[a-zA-Z0-9,\.\-_]$/))
                        result += raw_value[i];
                    else if(raw_value[i].match(/^[&<>"]$/))
                        result += raw_value[i].replace(/&/g, "&amp;")
                                .replace(/</g, "&lt;")
                                .replace(/>/g, "&gt;")
                                .replace(/"/g, "&quot;");
                    else {
                        var char_code = raw_value.charCodeAt(i);

                        // The following replaces characters undefined in HTML with
                        // the hex entity for the Unicode replacement character.
                        if(char_code <= 0x1f && char_code != 0x09 && char_code != 0x0a && char_code != 0x0d)
                            result += "&#xFFFD;";
                        else if(char_code < 0x80)
                            result += Twig.lib.sprintf("&#x%02s;", char_code.toString(16).toUpperCase());
                        else
                            result += Twig.lib.sprintf("&#x%04s;", char_code.toString(16).toUpperCase());
                    }
                }

                return Twig.Markup(result, 'html_attr');
            } else {
                throw new Twig.Error("escape strategy unsupported");
            }
        },

        /* Alias of escape */
        "e": function(value, params) {
            return Twig.filters.escape(value, params);
        },

        nl2br: function(value) {
            if (value === undefined || value === null){
                return;
            }
            var linebreak_tag = "BACKSLASH_n_replace",
                br = "<br />" + linebreak_tag;

            value = Twig.filters.escape(value)
                        .replace(/\r\n/g, br)
                        .replace(/\r/g, br)
                        .replace(/\n/g, br);

            value = Twig.lib.replaceAll(value, linebreak_tag, "\n");

            return Twig.Markup(value);
        },

        /**
         * Adapted from: http://phpjs.org/functions/number_format:481
         */
        number_format: function(value, params) {
            var number = value,
                decimals = (params && params[0]) ? params[0] : undefined,
                dec      = (params && params[1] !== undefined) ? params[1] : ".",
                sep      = (params && params[2] !== undefined) ? params[2] : ",";

            number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                s = '',
                toFixedFix = function (n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };
            // Fix for IE parseFloat(0.55).toFixed(0) = 0;
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        },

        trim: function(value, params) {
            if (value === undefined|| value === null){
                return;
            }

            var str = Twig.filters.escape( '' + value ),
                whitespace;
            if ( params && params[0] ) {
                whitespace = '' + params[0];
            } else {
                whitespace = ' \n\r\t\f\x0b\xa0\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u200b\u2028\u2029\u3000';
            }
            for (var i = 0; i < str.length; i++) {
                if (whitespace.indexOf(str.charAt(i)) === -1) {
                    str = str.substring(i);
                    break;
                }
            }
            for (i = str.length - 1; i >= 0; i--) {
                if (whitespace.indexOf(str.charAt(i)) === -1) {
                    str = str.substring(0, i + 1);
                    break;
                }
            }
            return whitespace.indexOf(str.charAt(0)) === -1 ? str : '';
        },

        truncate: function (value, params) {
            var length = 30,
                preserve = false,
                separator = '...';

            value =  value + '';
            if (params) {
                if (params[0]) {
                    length = params[0];
                }
                if (params[1]) {
                    preserve = params[1];
                }
                if (params[2]) {
                    separator = params[2];
                }
            }

            if (value.length > length) {

                if (preserve) {
                    length = value.indexOf(' ', length);
                    if (length === -1) {
                        return value;
                    }
                }

                value =  value.substr(0, length) + separator;
            }

            return value;
        },

        slice: function(value, params) {
            if (value === undefined || value === null) {
                return;
            }
            if (params === undefined || params.length < 1) {
                throw new Twig.Error("slice filter expects at least 1 argument");
            }

            // default to start of string
            var start = params[0] || 0;
            // default to length of string
            var length = params.length > 1 ? params[1] : value.length;
            // handle negative start values
            var startIndex = start >= 0 ? start : Math.max( value.length + start, 0 );

            if (Twig.lib.is("Array", value)) {
                var output = [];
                for (var i = startIndex; i < startIndex + length && i < value.length; i++) {
                    output.push(value[i]);
                }
                return output;
            } else if (Twig.lib.is("String", value)) {
                return value.substr(startIndex, length);
            } else {
                throw new Twig.Error("slice filter expects value to be an array or string");
            }
        },

        abs: function(value) {
            if (value === undefined || value === null) {
                return;
            }

            return Math.abs(value);
        },

        first: function(value) {
            if (is("Array", value)) {
                return value[0];
            } else if (is("Object", value)) {
                if ('_keys' in value) {
                    return value[value._keys[0]];
                }
            } else if ( typeof value === "string" ) {
                return value.substr(0, 1);
            }

            return;
        },

        split: function(value, params) {
            if (value === undefined || value === null) {
                return;
            }
            if (params === undefined || params.length < 1 || params.length > 2) {
                throw new Twig.Error("split filter expects 1 or 2 argument");
            }
            if (Twig.lib.is("String", value)) {
                var delimiter = params[0],
                    limit = params[1],
                    split = value.split(delimiter);

                if (limit === undefined) {

                    return split;

                } else if (limit < 0) {

                    return value.split(delimiter, split.length + limit);

                } else {

                    var limitedSplit = [];

                    if (delimiter == '') {
                        // empty delimiter
                        // "aabbcc"|split('', 2)
                        //     -> ['aa', 'bb', 'cc']

                        while(split.length > 0) {
                            var temp = "";
                            for (var i=0; i<limit && split.length > 0; i++) {
                                temp += split.shift();
                            }
                            limitedSplit.push(temp);
                        }

                    } else {
                        // non-empty delimiter
                        // "one,two,three,four,five"|split(',', 3)
                        //     -> ['one', 'two', 'three,four,five']

                        for (var i=0; i<limit-1 && split.length > 0; i++) {
                            limitedSplit.push(split.shift());
                        }

                        if (split.length > 0) {
                            limitedSplit.push(split.join(delimiter));
                        }
                    }

                    return limitedSplit;
                }

            } else {
                throw new Twig.Error("split filter expects value to be a string");
            }
        },
        last: function(value) {
            if (Twig.lib.is('Object', value)) {
                var keys;

                if (value._keys === undefined) {
                    keys = Object.keys(value);
                } else {
                    keys = value._keys;
                }

                return value[keys[keys.length - 1]];
            }

            // string|array
            return value[value.length - 1];
        },
        raw: function(value) {
            return Twig.Markup(value);
        },
        batch: function(items, params) {
            var size = params.shift(),
                fill = params.shift(),
                result,
                last,
                missing;

            if (!Twig.lib.is("Array", items)) {
                throw new Twig.Error("batch filter expects items to be an array");
            }

            if (!Twig.lib.is("Number", size)) {
                throw new Twig.Error("batch filter expects size to be a number");
            }

            size = Math.ceil(size);

            result = Twig.lib.chunkArray(items, size);

            if (fill && items.length % size != 0) {
                last = result.pop();
                missing = size - last.length;

                while (missing--) {
                    last.push(fill);
                }

                result.push(last);
            }

            return result;
        },
        round: function(value, params) {
            params = params || [];

            var precision = params.length > 0 ? params[0] : 0,
                method = params.length > 1 ? params[1] : "common";

            value = parseFloat(value);

            if(precision && !Twig.lib.is("Number", precision)) {
                throw new Twig.Error("round filter expects precision to be a number");
            }

            if (method === "common") {
                return Twig.lib.round(value, precision);
            }

            if(!Twig.lib.is("Function", Math[method])) {
                throw new Twig.Error("round filter expects method to be 'floor', 'ceil', or 'common'");
            }

            return Math[method](value * Math.pow(10, precision)) / Math.pow(10, precision);
        }
    };

    Twig.filter = function(filter, value, params) {
        if (!Twig.filters[filter]) {
            throw "Unable to find filter " + filter;
        }
        return Twig.filters[filter].apply(this, [value, params]);
    };

    Twig.filter.extend = function(filter, definition) {
        Twig.filters[filter] = definition;
    };

    return Twig;

})(Twig || { });
//     Twig.js
//                   2012 Hadrien Lanneau
//     Available under the BSD 2-Clause License
//     https://github.com/justjohn/twig.js

// ## twig.functions.js
//
// This file handles parsing filters.
var Twig = (function (Twig) {
    /**
     * @constant
     * @type {string}
     */
    var TEMPLATE_NOT_FOUND_MESSAGE = 'Template "{name}" is not defined.';

    // Determine object type
    function is(type, obj) {
        var clas = Object.prototype.toString.call(obj).slice(8, -1);
        return obj !== undefined && obj !== null && clas === type;
    }

    Twig.functions = {
        //  attribute, block, constant, date, dump, parent, random,.

        // Range function from http://phpjs.org/functions/range:499
        // Used under an MIT License
        range: function (low, high, step) {
            // http://kevin.vanzonneveld.net
            // +   original by: Waldo Malqui Silva
            // *     example 1: range ( 0, 12 );
            // *     returns 1: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
            // *     example 2: range( 0, 100, 10 );
            // *     returns 2: [0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100]
            // *     example 3: range( 'a', 'i' );
            // *     returns 3: ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i']
            // *     example 4: range( 'c', 'a' );
            // *     returns 4: ['c', 'b', 'a']
            var matrix = [];
            var inival, endval, plus;
            var walker = step || 1;
            var chars = false;

            if (!isNaN(low) && !isNaN(high)) {
                inival = parseInt(low, 10);
                endval = parseInt(high, 10);
            } else if (isNaN(low) && isNaN(high)) {
                chars = true;
                inival = low.charCodeAt(0);
                endval = high.charCodeAt(0);
            } else {
                inival = (isNaN(low) ? 0 : low);
                endval = (isNaN(high) ? 0 : high);
            }

            plus = ((inival > endval) ? false : true);
            if (plus) {
                while (inival <= endval) {
                    matrix.push(((chars) ? String.fromCharCode(inival) : inival));
                    inival += walker;
                }
            } else {
                while (inival >= endval) {
                    matrix.push(((chars) ? String.fromCharCode(inival) : inival));
                    inival -= walker;
                }
            }

            return matrix;
        },
        cycle: function(arr, i) {
            var pos = i % arr.length;
            return arr[pos];
        },
        dump: function() {
            var EOL = '\n',
                indentChar = '  ',
                indentTimes = 0,
                out = '',
                args = Array.prototype.slice.call(arguments),
                indent = function(times) {
                    var ind  = '';
                    while (times > 0) {
                        times--;
                        ind += indentChar;
                    }
                    return ind;
                },
                displayVar = function(variable) {
                    out += indent(indentTimes);
                    if (typeof(variable) === 'object') {
                        dumpVar(variable);
                    } else if (typeof(variable) === 'function') {
                        out += 'function()' + EOL;
                    } else if (typeof(variable) === 'string') {
                        out += 'string(' + variable.length + ') "' + variable + '"' + EOL;
                    } else if (typeof(variable) === 'number') {
                        out += 'number(' + variable + ')' + EOL;
                    } else if (typeof(variable) === 'boolean') {
                        out += 'bool(' + variable + ')' + EOL;
                    }
                },
                dumpVar = function(variable) {
                    var i;
                    if (variable === null) {
                        out += 'NULL' + EOL;
                    } else if (variable === undefined) {
                        out += 'undefined' + EOL;
                    } else if (typeof variable === 'object') {
                        out += indent(indentTimes) + typeof(variable);
                        indentTimes++;
                        out += '(' + (function(obj) {
                            var size = 0, key;
                            for (key in obj) {
                                if (obj.hasOwnProperty(key)) {
                                    size++;
                                }
                            }
                            return size;
                        })(variable) + ') {' + EOL;
                        for (i in variable) {
                            out += indent(indentTimes) + '[' + i + ']=> ' + EOL;
                            displayVar(variable[i]);
                        }
                        indentTimes--;
                        out += indent(indentTimes) + '}' + EOL;
                    } else {
                        displayVar(variable);
                    }
                };

            // handle no argument case by dumping the entire render context
            if (args.length == 0) args.push(this.context);

            Twig.forEach(args, function(variable) {
                dumpVar(variable);
            });

            return out;
        },
        date: function(date, time) {
            var dateObj;
            if (date === undefined) {
                dateObj = new Date();
            } else if (Twig.lib.is("Date", date)) {
                dateObj = date;
            } else if (Twig.lib.is("String", date)) {
                if (date.match(/^[0-9]+$/)) {
                    dateObj = new Date(date * 1000);
                }
                else {
                    dateObj = new Date(Twig.lib.strtotime(date) * 1000);
                }
            } else if (Twig.lib.is("Number", date)) {
                // timestamp
                dateObj = new Date(date * 1000);
            } else {
                throw new Twig.Error("Unable to parse date " + date);
            }
            return dateObj;
        },
        block: function(block) {
            if (this.originalBlockTokens[block]) {
                return Twig.logic.parse.apply(this, [this.originalBlockTokens[block], this.context]).output;
            } else {
                return this.blocks[block];
            }
        },
        parent: function() {
            // Add a placeholder
            return Twig.placeholders.parent;
        },
        attribute: function(object, method, params) {
            if (Twig.lib.is('Object', object)) {
                if (object.hasOwnProperty(method)) {
                    if (typeof object[method] === "function") {
                        return object[method].apply(undefined, params);
                    }
                    else {
                        return object[method];
                    }
                }
            }
            // Array will return element 0-index
            return object[method] || undefined;
        },
        max: function(values) {
            if(Twig.lib.is("Object", values)) {
                delete values["_keys"];
                return Twig.lib.max(values);
            }

            return Twig.lib.max.apply(null, arguments);
        },
        min: function(values) {
            if(Twig.lib.is("Object", values)) {
                delete values["_keys"];
                return Twig.lib.min(values);
            }

            return Twig.lib.min.apply(null, arguments);
        },
        template_from_string: function(template) {
            if (template === undefined) {
                template = '';
            }
            return Twig.Templates.parsers.twig({
                options: this.options,
                data: template
            });
        },
        random: function(value) {
            var LIMIT_INT31 = 0x80000000;

            function getRandomNumber(n) {
                var random = Math.floor(Math.random() * LIMIT_INT31);
                var limits = [0, n];
                var min = Math.min.apply(null, limits),
                    max = Math.max.apply(null, limits);
                return min + Math.floor((max - min + 1) * random / LIMIT_INT31);
            }

            if(Twig.lib.is("Number", value)) {
                return getRandomNumber(value);
            }

            if(Twig.lib.is("String", value)) {
                return value.charAt(getRandomNumber(value.length-1));
            }

            if(Twig.lib.is("Array", value)) {
                return value[getRandomNumber(value.length-1)];
            }

            if(Twig.lib.is("Object", value)) {
                var keys = Object.keys(value);
                return value[keys[getRandomNumber(keys.length-1)]];
            }

            return getRandomNumber(LIMIT_INT31-1);
        },

        /**
         * Returns the content of a template without rendering it
         * @param {string} name
         * @param {boolean} [ignore_missing=false]
         * @returns {string}
         */
        source: function(name, ignore_missing) {
            var templateSource;
            var templateFound = false;
            var isNodeEnvironment = typeof module !== 'undefined' && typeof module.exports !== 'undefined' && typeof window === 'undefined';
            var loader;
            var path;

            //if we are running in a node.js environment, set the loader to 'fs' and ensure the
            // path is relative to the CWD of the running script
            //else, set the loader to 'ajax' and set the path to the value of name
            if (isNodeEnvironment) {
                loader = 'fs';
                path = __dirname + '/' + name;
            } else {
                loader = 'ajax';
                path = name;
            }

            //build the params object
            var params = {
                id: name,
                path: path,
                method: loader,
                parser: 'source',
                async: false,
                fetchTemplateSource: true
            };

            //default ignore_missing to false
            if (typeof ignore_missing === 'undefined') {
                ignore_missing = false;
            }

            //try to load the remote template
            //
            //on exception, log it
            try {
                templateSource = Twig.Templates.loadRemote(name, params);

                //if the template is undefined or null, set the template to an empty string and do NOT flip the
                // boolean indicating we found the template
                //
                //else, all is good! flip the boolean indicating we found the template
                if (typeof templateSource === 'undefined' || templateSource === null) {
                    templateSource = '';
                } else {
                    templateFound = true;
                }
            } catch (e) {
                Twig.log.debug('Twig.functions.source: ', 'Problem loading template  ', e);
            }

            //if the template was NOT found AND we are not ignoring missing templates, return the same message
            // that is returned by the PHP implementation of the twig source() function
            //
            //else, return the template source
            if (!templateFound && !ignore_missing) {
                return TEMPLATE_NOT_FOUND_MESSAGE.replace('{name}', name);
            } else {
                return templateSource;
            }
        }
    };

    Twig._function = function(_function, value, params) {
        if (!Twig.functions[_function]) {
            throw "Unable to find function " + _function;
        }
        return Twig.functions[_function](value, params);
    };

    Twig._function.extend = function(_function, definition) {
        Twig.functions[_function] = definition;
    };

    return Twig;

})(Twig || { });
//     Twig.js
//     Available under the BSD 2-Clause License
//     https://github.com/justjohn/twig.js

// ## twig.path.js
//
// This file handles path parsing
var Twig = (function (Twig) {
    "use strict";

    /**
     * Namespace for path handling.
     */
    Twig.path = {};

    /**
     * Generate the canonical version of a url based on the given base path and file path and in
     * the previously registered namespaces.
     *
     * @param  {string} template The Twig Template
     * @param  {string} file     The file path, may be relative and may contain namespaces.
     *
     * @return {string}          The canonical version of the path
     */
     Twig.path.parsePath = function(template, file) {
        var namespaces = null,
            file = file || "";

        if (typeof template === 'object' && typeof template.options === 'object') {
            namespaces = template.options.namespaces;
        }

        if (typeof namespaces === 'object' && (file.indexOf('::') > 0) || file.indexOf('@') >= 0){
            for (var k in namespaces){
                if (namespaces.hasOwnProperty(k)) {
                    file = file.replace(k + '::', namespaces[k]);
                    file = file.replace('@' + k, namespaces[k]);
                }
            }

            return file;
        }

        return Twig.path.relativePath(template, file);
    };

    /**
     * Generate the relative canonical version of a url based on the given base path and file path.
     *
     * @param {Twig.Template} template The Twig.Template.
     * @param {string} file The file path, relative to the base path.
     *
     * @return {string} The canonical version of the path.
     */
    Twig.path.relativePath = function(template, file) {
        var base,
            base_path,
            sep_chr = "/",
            new_path = [],
            file = file || "",
            val;

        if (template.url) {
            if (typeof template.base !== 'undefined') {
                base = template.base + ((template.base.charAt(template.base.length-1) === '/') ? '' : '/');
            } else {
                base = template.url;
            }
        } else if (template.path) {
            // Get the system-specific path separator
            var path = require("path"),
                sep = path.sep || sep_chr,
                relative = new RegExp("^\\.{1,2}" + sep.replace("\\", "\\\\"));
            file = file.replace(/\//g, sep);

            if (template.base !== undefined && file.match(relative) == null) {
                file = file.replace(template.base, '');
                base = template.base + sep;
            } else {
                base = path.normalize(template.path);
            }

            base = base.replace(sep+sep, sep);
            sep_chr = sep;
        } else if ((template.name || template.id) && template.method && template.method !== 'fs' && template.method !== 'ajax') {
            // Custom registered loader
            base = template.base || template.name || template.id;
        } else {
            throw new Twig.Error("Cannot extend an inline template.");
        }

        base_path = base.split(sep_chr);

        // Remove file from url
        base_path.pop();
        base_path = base_path.concat(file.split(sep_chr));

        while (base_path.length > 0) {
            val = base_path.shift();
            if (val == ".") {
                // Ignore
            } else if (val == ".." && new_path.length > 0 && new_path[new_path.length-1] != "..") {
                new_path.pop();
            } else {
                new_path.push(val);
            }
        }

        return new_path.join(sep_chr);
    };

    return Twig;
}) (Twig || { });
//     Twig.js
//     Available under the BSD 2-Clause License
//     https://github.com/justjohn/twig.js

// ## twig.tests.js
//
// This file handles expression tests. (is empty, is not defined, etc...)
var Twig = (function (Twig) {
    "use strict";
    Twig.tests = {
        empty: function(value) {
            if (value === null || value === undefined) return true;
            // Handler numbers
            if (typeof value === "number") return false; // numbers are never "empty"
            // Handle strings and arrays
            if (value.length && value.length > 0) return false;
            // Handle objects
            for (var key in value) {
                if (value.hasOwnProperty(key)) return false;
            }
            return true;
        },
        odd: function(value) {
            return value % 2 === 1;
        },
        even: function(value) {
            return value % 2 === 0;
        },
        divisibleby: function(value, params) {
            return value % params[0] === 0;
        },
        defined: function(value) {
            return value !== undefined;
        },
        none: function(value) {
            return value === null;
        },
        'null': function(value) {
            return this.none(value); // Alias of none
        },
        sameas: function(value, params) {
            return value === params[0];
        },
        iterable: function(value) {
            return value && (Twig.lib.is("Array", value) || Twig.lib.is("Object", value));
        }
        /*
        constant ?
         */
    };

    Twig.test = function(test, value, params) {
        if (!Twig.tests[test]) {
            throw "Test " + test + " is not defined.";
        }
        return Twig.tests[test](value, params);
    };

    Twig.test.extend = function(test, definition) {
        Twig.tests[test] = definition;
    };

    return Twig;
})( Twig || { } );
//     Twig.js
//     Available under the BSD 2-Clause License
//     https://github.com/justjohn/twig.js

// ## twig.exports.js
//
// This file provides extension points and other hooks into the twig functionality.

var Twig = (function (Twig) {
    "use strict";
    Twig.exports = {
        VERSION: Twig.VERSION
    };

    /**
     * Create and compile a twig.js template.
     *
     * @param {Object} param Paramteres for creating a Twig template.
     *
     * @return {Twig.Template} A Twig template ready for rendering.
     */
    Twig.exports.twig = function twig(params) {
        'use strict';
        var id = params.id,
            options = {
                strict_variables: params.strict_variables || false,
                // TODO: turn autoscape on in the next major version
                autoescape: params.autoescape != null && params.autoescape || false,
                allowInlineIncludes: params.allowInlineIncludes || false,
                rethrow: params.rethrow || false,
                namespaces: params.namespaces
            };

        if (Twig.cache && id) {
            Twig.validateId(id);
        }

        if (params.debug !== undefined) {
            Twig.debug = params.debug;
        }
        if (params.trace !== undefined) {
            Twig.trace = params.trace;
        }

        if (params.data !== undefined) {
            return Twig.Templates.parsers.twig({
                data: params.data,
                path: params.hasOwnProperty('path') ? params.path : undefined,
                module: params.module,
                id:   id,
                options: options
            });

        } else if (params.ref !== undefined) {
            if (params.id !== undefined) {
                throw new Twig.Error("Both ref and id cannot be set on a twig.js template.");
            }
            return Twig.Templates.load(params.ref);
        
        } else if (params.method !== undefined) {
            if (!Twig.Templates.isRegisteredLoader(params.method)) {
                throw new Twig.Error('Loader for "' + params.method + '" is not defined.');
            }
            return Twig.Templates.loadRemote(params.name || params.href || params.path || id || undefined, {
                id: id,
                method: params.method,
                parser: params.parser || 'twig',
                base: params.base,
                module: params.module,
                precompiled: params.precompiled,
                async: params.async,
                options: options

            }, params.load, params.error);

        } else if (params.href !== undefined) {
            return Twig.Templates.loadRemote(params.href, {
                id: id,
                method: 'ajax',
                parser: params.parser || 'twig',
                base: params.base,
                module: params.module,
                precompiled: params.precompiled,
                async: params.async,
                options: options

            }, params.load, params.error);

        } else if (params.path !== undefined) {
            return Twig.Templates.loadRemote(params.path, {
                id: id,
                method: 'fs',
                parser: params.parser || 'twig',
                base: params.base,
                module: params.module,
                precompiled: params.precompiled,
                async: params.async,
                options: options

            }, params.load, params.error);
        }
    };

    // Extend Twig with a new filter.
    Twig.exports.extendFilter = function(filter, definition) {
        Twig.filter.extend(filter, definition);
    };

    // Extend Twig with a new function.
    Twig.exports.extendFunction = function(fn, definition) {
        Twig._function.extend(fn, definition);
    };

    // Extend Twig with a new test.
    Twig.exports.extendTest = function(test, definition) {
        Twig.test.extend(test, definition);
    };

    // Extend Twig with a new definition.
    Twig.exports.extendTag = function(definition) {
        Twig.logic.extend(definition);
    };

    // Provide an environment for extending Twig core.
    // Calls fn with the internal Twig object.
    Twig.exports.extend = function(fn) {
        fn(Twig);
    };


    /**
     * Provide an extension for use with express 2.
     *
     * @param {string} markup The template markup.
     * @param {array} options The express options.
     *
     * @return {string} The rendered template.
     */
    Twig.exports.compile = function(markup, options) {
        var id = options.filename,
            path = options.filename,
            template;

        // Try to load the template from the cache
        template = new Twig.Template({
            data: markup,
            path: path,
            id: id,
            options: options.settings['twig options']
        }); // Twig.Templates.load(id) ||

        return function(context) {
            return template.render(context);
        };
    };

    /**
     * Provide an extension for use with express 3.
     *
     * @param {string} path The location of the template file on disk.
     * @param {Object|Function} The options or callback.
     * @param {Function} fn callback.
     * 
     * @throws Twig.Error
     */
    Twig.exports.renderFile = function(path, options, fn) {
        // handle callback in options
        if (typeof options === 'function') {
            fn = options;
            options = {};
        }

        options = options || {};

        var settings = options.settings || {};

        var params = {
            path: path,
            base: settings.views,
            load: function(template) {
                // render and return template
                fn(null, template.render(options));
            }
        };

        // mixin any options provided to the express app.
        var view_options = settings['twig options'];

        if (view_options) {
            for (var option in view_options) {
                if (view_options.hasOwnProperty(option)) {
                    params[option] = view_options[option];
                }
            }
        }

        Twig.exports.twig(params);
    };

    // Express 3 handler
    Twig.exports.__express = Twig.exports.renderFile;

    /**
     * Shoud Twig.js cache templates.
     * Disable during development to see changes to templates without
     * reloading, and disable in production to improve performance.
     *
     * @param {boolean} cache
     */
    Twig.exports.cache = function(cache) {
        Twig.cache = cache;
    };

    //We need to export the path module so we can effectively test it
    Twig.exports.path = Twig.path;

    return Twig;
}) (Twig || { });

//     Twig.js
//     Available under the BSD 2-Clause License
//     https://github.com/justjohn/twig.js

// ## twig.compiler.js
//
// This file handles compiling templates into JS
var Twig = (function (Twig) {
    /**
     * Namespace for compilation.
     */
    Twig.compiler = {
        module: {}
    };

    // Compile a Twig Template to output.
    Twig.compiler.compile = function(template, options) {
        // Get tokens
        var tokens = JSON.stringify(template.tokens)
            , id = template.id
            , output;

        if (options.module) {
            if (Twig.compiler.module[options.module] === undefined) {
                throw new Twig.Error("Unable to find module type " + options.module);
            }
            output = Twig.compiler.module[options.module](id, tokens, options.twig);
        } else {
            output = Twig.compiler.wrap(id, tokens);
        }
        return output;
    };

    Twig.compiler.module = {
        amd: function(id, tokens, pathToTwig) {
            return 'define(["' + pathToTwig + '"], function (Twig) {\n\tvar twig, templates;\ntwig = Twig.twig;\ntemplates = ' + Twig.compiler.wrap(id, tokens) + '\n\treturn templates;\n});';
        }
        , node: function(id, tokens) {
            return 'var twig = require("twig").twig;\n'
                + 'exports.template = ' + Twig.compiler.wrap(id, tokens)
        }
        , cjs2: function(id, tokens, pathToTwig) {
            return 'module.declare([{ twig: "' + pathToTwig + '" }], function (require, exports, module) {\n'
                        + '\tvar twig = require("twig").twig;\n'
                        + '\texports.template = ' + Twig.compiler.wrap(id, tokens)
                    + '\n});'
        }
    };

    Twig.compiler.wrap = function(id, tokens) {
        return 'twig({id:"'+id.replace('"', '\\"')+'", data:'+tokens+', precompiled: true});\n';
    };

    return Twig;
})(Twig || {});
//     Twig.js
//     Available under the BSD 2-Clause License
//     https://github.com/justjohn/twig.js

// ## twig.module.js
// Provide a CommonJS/AMD/Node module export.

if (typeof module !== 'undefined' && module.declare) {
    // Provide a CommonJS Modules/2.0 draft 8 module
    module.declare([], function(require, exports, module) {
        // Add exports from the Twig exports
        for (key in Twig.exports) {
            if (Twig.exports.hasOwnProperty(key)) {
                exports[key] = Twig.exports[key];
            }
        }
    });
} else if (typeof define == 'function' && define.amd) {
    define(function() {
        return Twig.exports;
    });
} else if (typeof module !== 'undefined' && module.exports) {
    // Provide a CommonJS Modules/1.1 module
    module.exports = Twig.exports;
} else {
    // Export for browser use
    window.twig = Twig.exports.twig;
    window.Twig = Twig.exports;
}

;$(document).ready(function() {

    $(".js-messenger-form").on('submit', function(e) {
        $(this).find("input[type=submit]").prop('disabled', true);
    });

    // Ajax to load previous message.
    var mmessengerp             = 1,
        $loader                 = $(".js-thread-loader"),
        $threadMessages         = $(".js-thread-messages"),
        $threadErrorMessage     = $(".js-thread-error-message"),
        $threadNoMoreMessage    = $(".js-thread-no-more-message"),
        dataHasMore             = $threadMessages.data("has-more"),
        dataUrl                 = $threadMessages.data("url"),
        dataNumberPerPage       = $threadMessages.data("number-per-page"),
        dataTemplateUrl         = $threadMessages.data("template-url"),
        dataThreadId            = $threadMessages.data("thread-id"),
        threadSecret            = $(".js-messenger-form").find('input[name="secret"]').val(),
        userEmail               = $(".js-messenger-form").find('input[name="email"]').val(),
        dataContentRead         = $threadMessages.data("content-read"),
        dataContentDelete       = $threadMessages.data("content-delete"),
        dataContentDeleteAction = $threadMessages.data("content-delete-action"),
        running                 = false,
        threadMessagesHeight    = getThreadMessagesHeight(),
        template                = twig({
            id: "message", // id is optional, but useful for referencing the template later
            href: dataTemplateUrl,
            async: false
        });

    $(window).scroll(function() {
        if($(window).scrollTop()+$(window).height() >= threadMessagesHeight && !running)
        {
            loadMessages();
        }
    });

    function getThreadMessagesHeight() {
        return Math.round($threadMessages.offset().top + $threadMessages.outerHeight(true));
    }

	function loadMessages() {
        if(dataHasMore) {
            running = true;
            $loader.show();

    		$.ajax({
    			type: "GET",
    			url: dataUrl,
    			data: {
    				"do": "more",
    				"n": dataNumberPerPage,
    				"p": mmessengerp + 1,
    				"tid": dataThreadId,
                    "secret": threadSecret,
                    "email": userEmail,
    			},
    			dataType: "json",
    			success: function(response, text, jqXHR) {

                    if (response.error) {
                        dataHasMore = false;
                        $threadErrorMessage.append(response.reason);
                        $loader.hide();
                        $threadErrorMessage.fadeIn();
                    } else {
                        var output = twig({ref:"message"}).render({
                            messages: response.data,
                            content: {
                                read: dataContentRead,
                                delete: dataContentDelete,
                                deleteAction: dataContentDeleteAction
                            }
                        });
                        output = output.replace(/[\u200B]/g, '');

                        $threadMessages.append(output);

                        // Is there more messages in this thread?
                        if(response.hasMore == false) {
                            dataHasMore = false;
                            $threadNoMoreMessage.fadeIn();
                        } else {
                            running = false;
                            threadMessagesHeight = getThreadMessagesHeight();
                        }
                        $loader.hide();
                        runAutoLlinker();
                        ++mmessengerp;
                    }
    			},
                error: function(xhr, ajaxOptions, thrownError) {
                    $loader.hide();
                    $threadNoMoreMessage.fadeIn();
                    dataHasMore = false;
                }
    		});
        }
    }


    $('.fancybox').fancybox({
        type        : 'image',
        beforeLoad : function() {
            this.title = 'Image ' + (this.index + 1) + ' of ' + this.group.length + (this.title ? ' - ' + this.title : '');
        }
    });


    function runAutoLlinker() {
        if ($('.js-thread-messages').length > 0) {
            $jsMessages = $('.js-thread-messages');

            if ($jsMessages.data('autolinker-enable') == '1') {
                var autolinker = new Autolinker(
                    {
                        newWindow: $jsMessages.data('autolinker-new-window'),
                        stripPrefix: $jsMessages.data('autolinker-strip-prefix'),
                        truncate: $jsMessages.data('autolinker-truncate-length'),
                        "phone": false,
                        "hashtag": "twitter"
                    }
                );

                $(".js-text").map(function(e) {
                    $(this).html(autolinker.link($(this).html()));
                });
            }
        }
    }
    runAutoLlinker();
});

$(document).ready(function(){

    var $threadTitleContainer      = $('.js-thread-title-container'),
        $threadTitleEdit       = $('.js-thread-title-edit'),
        $addAttachment       = $('.js-add-attachment'),
        $attachmentWrapper   = $('.js-attachment-wrapper'),
        $attachmentContainer = $('.js-attachment-container'),
        maxFile              = $attachmentWrapper.data('attachment-max'),
        template             = $attachmentWrapper.clone();


    $threadTitleEdit.on("click", function (e) {
        e.preventDefault();
        $threadTitleContainer.fadeToggle();
    });

    $addAttachment.on("click", function (e) {
        $attachmentContainer.fadeToggle();
    });

    $(document).on("change", '.js-attachment-file', function(){

        if ($(this).find('input[type="file"]').val() != "") {
            $(this).closest(".form-group").find('.js-remove-button').removeClass('hidden');
        }

        var n = $('.js-attachment-wrapper').length + 1;
        if(n > maxFile || $('.js-attachment-wrapper:last').find('input[type="file"]').val() == "") {
            return false;
        }

        $('.js-attachment-wrapper:last').after(template.clone());
    });

    $(document).on('click', '.js-remove-button', function(e){
        e.preventDefault();

        var n = $('.js-attachment-wrapper').length;

        if (n == maxFile && $('.js-attachment-wrapper:last').closest(".form-group").find('.js-attachment-file').val() != "") {
            $('.js-attachment-wrapper:last').after(template.clone());
        }

        if ($(this).closest(".form-group").find('.js-attachment-file').val() != "") {
            $(this).closest(".form-group").remove();
        }
    });

});