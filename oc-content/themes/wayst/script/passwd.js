/*
 * A JavaScript class to perform basic password strength checking based on:
 *
 * --------------------------------------------------------------------
 * Simple Password Strength Checker
 * by Siddharth S, www.ssiddharth.com, hello@ssiddharth.com
 * for Net Tuts, www.net.tutsplus.com
 * Version: 1.0, 05.10.2009 	
 * --------------------------------------------------------------------

 * The class allows multiple instances of a password element to appear on a
 * single page by using a unique name argument for each password input.
 */

/**
 * Parameters are optional. When using PHPStorm construct the class and call the Password method.
 * @param name
 * @param construct
 * @constructor
 */
function Password (name,construct) {
    this.invalid           = true;
    this.reference         = name;
    this.strPassword       = null;
    this.charPassword      = null;
    this.complexity        = null;
    this.minPasswordLength = 8;
    this.baseScore         = 0;
    this.score             = 0;
    this.num               = {};
    this.bonus             = {};
    /*
     * Pseudo-constructor.
     */
    this.Password = function(name) {
        if (this.reference == undefined) {
            if (name == undefined) {
                this.reference = '';
            } else {
                this.reference = name;
            }
        }
        //noinspection JSJQueryEfficiency
        if ($('#pw-complexity'+this.reference).length && $('#newpassword'+this.reference).length) {
            // Indicate the instance as valid since the required markup elements exist on the page.
            this.invalid    = false;
            this.complexity = $('#pw-complexity' + this.reference);

            this.num.Excess  = 0;
            this.num.Upper   = 0;
            this.num.Numbers = 0;
            this.num.Symbols = 0;

            this.bonus.Excess     = 3;
            this.bonus.Upper      = 4;
            this.bonus.Numbers    = 5;
            this.bonus.Symbols    = 5;
            this.bonus.Combo      = 0;
            this.bonus.FlatLower  = 0;
            this.bonus.FlatNumber = 0;
            /*
             * http://api.jquery.com/on/
             */
            $('#newpassword' + this.reference).on('keyup', null, this, this.evaluatePassword);
            this.output();
        }
    };
    this.initialise = function() {
        if (this.invalid == false) {
            this.strPassword  = $('#newpassword' + this.reference).val();
            this.charPassword = this.strPassword.split('');
        }
        this.num.Excess  = 0;
        this.num.Upper   = 0;
        this.num.Numbers = 0;
        this.num.Symbols = 0;

        this.bonus.Combo      = 0;
        this.bonus.FlatLower  = 0;
        this.bonus.FlatNumber = 0;

        this.baseScore = 0;
        this.score     = 0;
    };
    this.evaluatePassword = function(e) {
    /*
     * The event e.data value must be set with the value of the class instance.
     */
        if (e.data) {
            e.data.onEvaluatePassword(e);
        }
    };
    //noinspection JSUnusedLocalSymbols
    this.onEvaluatePassword = function(e) {
        this.initialise();
        if (this.charPassword.length >= this.minPasswordLength) {
            this.baseScore = 50;
            this.analyzeString();
            this.calculateComplexity();
        } else {
            this.baseScore = 0;
        }
        this.output();
    };
    this.analyzeString = function() {
        for (var i=0; i<this.charPassword.length;i++) {
            if (this.charPassword[i].match(/[A-Z]/g)) {this.num.Upper++;}
            if (this.charPassword[i].match(/[0-9]/g)) {this.num.Numbers++;}
            if (this.charPassword[i].match(/(.*[!,@,#,$,%,^,&,*,?,_,~])/)) {this.num.Symbols++;}
        }

        this.num.Excess = this.charPassword.length - this.minPasswordLength;

        if (this.num.Upper && this.num.Numbers && this.num.Symbols) {
            this.bonus.Combo = 25;
        }
        else if ((this.num.Upper && this.num.Numbers) || (this.num.Upper && this.num.Symbols) || (this.num.Numbers && this.num.Symbols)) {
            this.bonus.Combo = 15;
        }

        if (this.strPassword.match(/^[\sa-z]+$/)) {
            this.bonus.FlatLower = -15;
        }

        if (this.strPassword.match(/^[\s0-9]+$/)) {
            this.bonus.FlatNumber = -35;
        }
    };
    this.calculateComplexity = function() {
        this.score = this.baseScore + 
            (this.num.Excess*this.bonus.Excess) + 
            (this.num.Upper*this.bonus.Upper) + 
            (this.num.Numbers*this.bonus.Numbers) + 
            (this.num.Symbols*this.bonus.Symbols) + this.bonus.Combo + this.bonus.FlatLower + this.bonus.FlatNumber;
    };
    this.output = function() {
        if ($("#newpassword"+this.reference).val()== "") {
            this.complexity.html("Password strength").removeClass("pw-weak pw-strong pw-stronger pw-strongest").addClass("pw-default");
        }
        else if (this.charPassword && this.charPassword.length < this.minPasswordLength) {
            this.complexity.html("At least " + this.minPasswordLength+ " characters").removeClass("pw-strong pw-stronger pw-strongest").addClass("pw-weak");
        }
        else if (this.score<65) {
            this.complexity.html("Weak").removeClass("pw-strong pw-stronger pw-strongest").addClass("pw-weak");
        }
        else if (this.score>=65 && this.score<75) {
            this.complexity.html("Average").removeClass("pw-stronger pw-strongest").addClass("pw-strong");
        }
        else if (this.score>=75 && this.score<100) {
            this.complexity.html("Strong").removeClass("pw-strongest").addClass("pw-stronger");
        }
        else if (this.score>=100) {
            this.complexity.html("Secure!").addClass("pw-strongest");
        }

        $("#details"+this.reference).html(
            "Base Score :<span class=\"value\">" + 
            this.baseScore + 
            "</span>" + 
            "<br />Length Bonus :<span class=\"value\">" + 
            (this.num.Excess*this.bonus.Excess) + 
            " [" + 
            this.num.Excess + 
            "x" + 
            this.bonus.Excess + 
            "]</span> " + 
            "<br />Upper case bonus :<span class=\"value\">" + 
            (this.num.Upper*this.bonus.Upper) + 
            " [" + 
            this.num.Upper + 
            "x" + 
            this.bonus.Upper + 
            "]</span> " + 
            "<br />Number Bonus :<span class=\"value\"> " + 
            (this.num.Numbers*this.bonus.Numbers) + 
            " [" + 
            this.num.Numbers + 
            "x" + 
            this.bonus.Numbers + 
            "]</span>" + 
            "<br />Symbol Bonus :<span class=\"value\"> " + 
            (this.num.Symbols*this.bonus.Symbols) + 
            " [" +
            this.num.Symbols +
            "x" + 
            this.bonus.Symbols + 
            "]</span>" + 
            "<br />Combination Bonus :<span class=\"value\"> " + 
            this.bonus.Combo + 
            "</span>" + 
            "<br />Lower case only penalty :<span class=\"value\"> " + 
            this.bonus.FlatLower + 
            "</span>" + 
            "<br />Numbers only penalty :<span class=\"value\"> " + 
            this.bonus.FlatNumber + 
            "</span>" + 
            "<br />Total Score:<span class=\"value\"> " + 
            this.score  + 
            "</span>"
        );
    };
    /*
     * Call the constructor.
     */
    if (construct != undefined && construct == true) {
        this.Password();
    }
}
