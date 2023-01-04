<?php

/**
 * Represents a Message for Madhouse Messenger.
 *
 * This class shows all the informations for one message part of a thread.
 *
 * @author Madhouse Design Co.
 * @package Madhouse
 * @subpackage Messenger
 * @since 1.00
 */
class Madhouse_Messenger_Message extends Madhouse_Entity
{
    /**
     * Message unique identifier.
     * @var int
     * @since 1.40
     */
    protected $id;

    /**
     * Thread in which belongs this message.
     * @var Madhouse_Messenger_ThreadSkeleton
     * @since 1.10
     */
	protected $thread;

	/**
	 * User that has send the message.
	 * @var Madhouse_User
	 * @since 1.00
	 */
	protected $sender;

    /**
     * Is the message blocked by an admin ?
     * @var Boolean
     * @since 1.00
     */
    protected $is_blocked;

    /**
     * Recipients of this message.
     * @var Array<Madhouse_User>
     * @since 1.10
     */
    private $recipients;

    /**
     * Text (content) of this message.
     * @var string
     * @since 1.00
     */
    private $_text;

    /**
     * Date (as an iso8601 string) when the message was sent.
     * @var a string.
     * @since 1.00
     */
	private $_sentOn;

	/**
	 * Status of this message (may be null).
	 * @var Madhouse_Messenger_Status
	 * @since 1.30
	 */
	private $status;

    /**
     * An event for this message (may be null).
     * @var Madhouse_Messenger_Event
     * @since 1.00
     */
	private $_event;

    /**
     * Does the sender has hid this message ?
     * @var Boolean
     * @since 1.10
     */
    private $_hidden;

    /**
     * Status (read/hidden) of the wrapped message.
     * @var instance of Madhouse_User
     * @since 1.10
     */
    private $_state;

    /**
     * Resources attached to this message.
     *
     * @var array
     *
     * @since 2.0.0
     */
    private $resources;

	/**
	 * Construct.
	 */
	function __construct($text, $sender, $recipients) {

		$this->setContent($text);
		$this->sender = $sender;
		$this->setRecipients($recipients);

        $this->resources = array();
        $this->is_blocked = false;
	}

    /**
     * Sets the unique identifier of this message.
     * @param an int.
     * @return $this message.
     */
	public function withId($id) {
		$this->id = $id;
		return $this;
	}

    /**
     * Gets the unique id of this message.
     * @return int
     * @since 1.40
     */
    public function getId()
    {
        return $this->id;
    }

	/**
	 * Sets the content of this message.
	 *
	 * It deletes (trim) blanks and blank lines from the beginning of the message
	 * and transforms multiple blank lines to only one blank line. Message should
	 * not be mutable but it must be if we want to edit it in a hook (hooks can't
	 * return anything...).
	 *
	 * @param $text (string)
	 * @since 1.00
	 */
	public function setContent($text) {
		$this->_text = html_entity_decode(preg_replace('/\n(\s*\n){2,}/', "\n\n", ltrim($text)), ENT_QUOTES, "utf-8");
	}

	/**
	 * Mark this message as hidden or not by its author.
	 * @param $hidden boolean value, true if hidden, false otherwise.
	 * @return $this message.
	 * @since 1.10
	 */
	public function withHidden($hidden) {
	    $this->_hidden = $hidden;
	    return $this;
	}

	public function withBlocked($is_blocked)
	{
	    if(! is_null($is_blocked)) {
    	    $this->is_blocked = $is_blocked;
    	}
	    return $this;
	}

	/**
	 * Sets the global status of this message.
	 * Tells who has read or hid this message among recipients and sender ?
	 * @param an associative array.
	 * @return $this message.
	 * @since 1.10
	 */
	public function withState(array $state) {
		$this->_state = $state;
		return $this;
	}

    /**
     * Is the message an auto-message.
     * @return true/false.
     * @since 1.22
     */
    public function isAuto()
    {
        return ($this->isBlocked() || $this->hasEvent());
    }

    public function isHiddenFor($user)
    {
        if (!$user instanceof Madhouse_User) {
            throw new InvalidArgumentException(
                "'user' must be an instance of Madhouse_User"
            );
        }

        if ($user->getId() === $this->getSender()->getId()) {
            // Return hidden status for sender.
            return $this->getHidden();
        }

        // Searching for given $userId in recipients.
        $userState = $this->getState($user->getId());

        // Return whether the message is deleted.
        return $userState["hidden"];
    }

    public function isReadFor($userId)
    {
        // Searching for given $userId in recipients.
        $userState = $this->getState($userId);

        // Return whether the message is deleted.
        return ($userState["read"]) ? true : false;
    }

	/**
	 * Sets the date when the message has been sent.
	 * ($this->sentOn === null) means this message is a DRAFT.
	 * @param $date a date in a iso8601 format preferably.
	 * @return $this message.
	 * @since 1.00
	 */
	public function withSentDate($date) {
		$this->_sentOn = $date;
		return $this;
	}

	public function withStatus($status) {
		$this->status = $status;
		return $this;
	}

	public function withThread($thread) {
		$this->thread = $thread;
		return $this;
	}

	public function withEvent($event) {
		$this->_event = $event;
		return $this;
	}

	public function hasEvent($key="") {
		if($key != "")
			return (isset($this->_event) && !empty($this->_event) && $this->_event->getName() == $key) ? true : false;
		return (isset($this->_event) && !empty($this->_event));
	}

	/**
	 * Returns the content of the message (its text).
	 * 	It just returns the content as it is stored (no html escaping or nl2br).
	 * @return a string.
	 */
	public function getContent() {
		return $this->_text;
	}

	/**
	 * Gets the text of this message.
	 * @return a html-encoded string with '\n' transformed as '<br />'.
	 */
	public function getText() {
        if($this->hasEvent()) {
            return osc_apply_filter("mdh_messenger_event_text", $this->getEvent()->getText(), $this);
        }

		return nl2br(htmlspecialchars($this->getContent()));
	}

	/**
	 * Gets a truncated text of this message.
	 * @return a html-encoded string
	 * @see Madhouse_Utils_Text::truncate()
	 * @since 1.00
	 */
	public function getExcerpt($length = 45, $oneline = true) {
        if($this->hasEvent()) {
            // Get the event excerpt.
            $excerpt = osc_apply_filter("mdh_messenger_event_excerpt", $this->getEvent()->getExcerpt(), $this);
        } else {
            $excerpt = htmlspecialchars($this->getContent());
        }

        // Truncate and return.
		return Madhouse_Utils_Text::truncate($excerpt, $length, "...", $oneline);
	}

    /**
     * Set sender of this message.
     *
     * @param Madhouse_User.
     *
     * @return $this
     *
     * @since  2.0.0
     */
    public function setSender($sender)
    {
        if (!$sender instanceof Madhouse_User) {
            throw new InvalidArgumentException();
        }
        $this->sender = $sender;
        return $this;
    }

	/**
	 * Gets the user that wrote the message.
	 * @return instance of Madhouse_User.
	 * @see Madhouse_User.
	 * @since 1.00
	 */
	public function getSender() {
		return $this->sender;
	}

    /**
     * Set the list of recipients of this message.
     *
     * @param array $recipients array of Madhouse_User objects.
     *
     * @return $this
     *
     * @since  2.0.0
     */
    public function setRecipients($recipients)
    {
        if (!is_array($recipients)) {
            throw new InvalidArgumentException();
        }

        $this->recipients = $recipients;
        return $this;
    }

    /**
     * Returns the list of recipients for this message.
     * @return Array<Madhouse_User>
     * @since 1.10
     */
    public function getRecipients()
    {
        return $this->recipients;
    }

    /**
     * Return all the users of this message.
     *
     * @return array
     *
     * @since  2.0.0
     */
    public function getUsers()
    {
        return array_merge(
            array($this->getSender()),
            $this->getRecipients()
        );
    }

    public function hasStatus()
    {
        return (isset($this->status) && !empty($this->status));
    }

	public function getStatus() {
		return $this->status;
	}

	/**
	 * Gets the date when the message has been sent.
	 * @return a string
	 */
	public function getSentDate() {
		return $this->_sentOn;
	}

	public function getFormattedSentDate() {
		return osc_format_date($this->getSentDate()) . " " . date(osc_time_format(), strtotime($this->getSentDate()));
	}

	protected function getHidden()
	{
	    return $this->_hidden;
	}

	/**
	 * Gets whether this message is is_blocked (spam/scam) or not.
	 * @returns a boolean.
	 */
	public function isBlocked() {
		return $this->is_blocked;
	}

    /**
     * Get the delete url for this message.
     *
     * @param  string $secret
     * @param  string $email
     *
     * @return string
     *
     * @since  2.0.0    Add secret and email to allow non-registered users.
     */
	public function getDeleteURL()
    {
        return mdh_messenger_message_delete_url($this->getId());
	}

    /**
     * Set the related thread to this message.
     *
     * @param  Madhouse_Messenger_ThreadSkeleton $thread.
     *
     * @return $this.
     *
     * @since  2.0.0.
     */
    public function setThread($thread)
    {
        if (!$thread instanceof Madhouse_Messenger_ThreadSkeleton) {
            throw new InvalidArgumentException(
                "'thread' must be a valid instance of Madhouse_Messenger_ThreadSkeleton"
            );
        }

        $this->thread = $thread;
        return $this;
    }

	public function getThread()
	{
		return $this->thread;
	}

	protected function getState($user = null)
	{
        if (is_null($user)) {
            // Return the whole state of the message.
            return $this->_state;
        }

        // Searching for given $userId in recipients.
        $userState = array_filter(
            $this->getState(),
            function ($s) use ($user) {
                return ($s["recipient"]->getId() === $user);
            }
        );

        if (count($userState) > 0) {
            // Found a recipient matching $userId.
            return $userState[0];
        }

        throw new RuntimeException(); // @TODO
	}

	public function getEvent()
	{
	    return $this->_event;
	}

    /**
     * Set the resources attached to this message.
     *
     * @param  array $resources.
     *
     * @return $this.
     */
    public function withResources($resources)
    {
        $this->resources = $resources;
        return $this;
    }

    /**
     * Returns the list of all resources attached to this message.
     *
     * @return array.
     */
    public function getResources()
    {
        return $this->resources;
    }

    /**
     * Returns whether this message has any resources or not.
     *
     * @return boolean.
     */
    public function hasResources()
    {
        return (count($this->resources) > 0);
    }

	/**
	 * Serialization utility.
	 * @returns an associative array of this object.
	 * @TODO : Use Serializable interface of PHP 5.4+
	 */
	public function toArray() {
		return array_merge(
		    parent::toArray(),
		    array(
    			"text" => $this->getText(),
    			"sent_date" => array(
    			    "raw" => $this->getSentDate(),
    			    "formatted" => $this->getFormattedSentDate(),
    			    "fb_formatted" => mdh_smart_date($this->getSentDate()),
    			),
    			"recipients" => array_map(function($v) { return $v->toArray(); }, $this->getRecipients()),
                "resources" => array_map(function($r) { return $r->toArray(); }, $this->getResources()),
    			"has_resources" => $this->hasResources(),
                "urls" => array(
    			    "delete" => $this->getDeleteURL()
    			)
    		)
		);
	}
}

?>