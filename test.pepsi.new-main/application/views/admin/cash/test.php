<!DOCTYPE html>
<!-- saved from url=(0078)http://demo-nexopos.tendoo.org/dashboard/stores/4/nexo/registers/__use/default -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <!-- Add Scale for mobile devices, @since 3.0.7 -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- End Add Scale for mobile devices -->
        <script type="text/javascript">
            var tendoo = new Object;
        </script>

        <link rel="stylesheet" href="./Shoezie World › Proceed a sale — NexoPOS_files/bootstrap.min.css">
        <link rel="stylesheet" href="./Shoezie World › Proceed a sale — NexoPOS_files/AdminLTE.min.css">
        <link rel="stylesheet" href="./Shoezie World › Proceed a sale — NexoPOS_files/tendoo.css">
        <link rel="stylesheet" href="./Shoezie World › Proceed a sale — NexoPOS_files/_all-skins.min.css">
        <link rel="stylesheet" href="./Shoezie World › Proceed a sale — NexoPOS_files/font-awesome.min.css">
        <link rel="stylesheet" href="./Shoezie World › Proceed a sale — NexoPOS_files/blue.css">
        <link rel="stylesheet" href="./Shoezie World › Proceed a sale — NexoPOS_files/animate.css">
        <link rel="stylesheet" href="./Shoezie World › Proceed a sale — NexoPOS_files/bootstrap-select.min.css">
        <script src="./Shoezie World › Proceed a sale — NexoPOS_files/jQuery-2.1.4.min.js"></script>
        <script src="./Shoezie World › Proceed a sale — NexoPOS_files/jquery-migrate-1.2.1.js"></script>
        <script src="./Shoezie World › Proceed a sale — NexoPOS_files/bootstrap.min.js"></script>
        <script src="./Shoezie World › Proceed a sale — NexoPOS_files/icheck.min.js"></script>
        <script src="./Shoezie World › Proceed a sale — NexoPOS_files/app.min.js"></script>
        <script src="./Shoezie World › Proceed a sale — NexoPOS_files/numeral.min.js"></script>
        <script src="./Shoezie World › Proceed a sale — NexoPOS_files/Chart.min.js"></script>
        <script src="./Shoezie World › Proceed a sale — NexoPOS_files/jquery.lazyload.js"></script>
        <script src="./Shoezie World › Proceed a sale — NexoPOS_files/bootstrap2-toggle.min.js"></script>
        <script src="./Shoezie World › Proceed a sale — NexoPOS_files/jquery.knob.js"></script>
        <script src="./Shoezie World › Proceed a sale — NexoPOS_files/jquery.slimscroll.min.js"></script>
        <script src="./Shoezie World › Proceed a sale — NexoPOS_files/heartcode-canvasloader-min.js"></script>
        <script src="./Shoezie World › Proceed a sale — NexoPOS_files/bootstrap-notify.min.js"></script>
        <script src="./Shoezie World › Proceed a sale — NexoPOS_files/tendoo.core.js"></script>
        <script src="./Shoezie World › Proceed a sale — NexoPOS_files/jquery.parseParams.js"></script>
        <script src="./Shoezie World › Proceed a sale — NexoPOS_files/bootbox.min.js"></script>
        <script src="./Shoezie World › Proceed a sale — NexoPOS_files/underscore-min.js"></script>
        <script src="./Shoezie World › Proceed a sale — NexoPOS_files/moment.min.js"></script>
        <script src="./Shoezie World › Proceed a sale — NexoPOS_files/bootstrap-select.min.js"></script>
        <meta name="mobile-web-app-capable" content="yes">
        <link rel="stylesheet" href="./Shoezie World › Proceed a sale — NexoPOS_files/jquery-ui.css">
        <script src="./Shoezie World › Proceed a sale — NexoPOS_files/jquery-ui.min.js"></script>
        <script src="./Shoezie World › Proceed a sale — NexoPOS_files/html5-audio-library.js"></script>
        <link rel="stylesheet" href="./Shoezie World › Proceed a sale — NexoPOS_files/bootstrap2-toggle.min.css">

        <!-- Include PIE CHARTS -->
        <link rel="stylesheet" href="./Shoezie World › Proceed a sale — NexoPOS_files/piecharts.css">
        <script type="text/javascript" src="./Shoezie World › Proceed a sale — NexoPOS_files/piecharts.js"></script>
        <script type="text/javascript">

            "use strict";

            // Money format

            Number.prototype.format = function(n, x, s, c) {
                var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
                        num = this.toFixed(Math.max(0, ~~n));

                return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
            };

            // Nexo API

            var NexoAPI = new Object();

            /*
             jQuery Hooks for WordPress, now for NexoPOS
             
             Examples:
             
             // Add three different test actions
             NexoAPI.events.addAction( 'test', function() { alert('Foo!'); } );
             NexoAPI.events.addAction( 'test', function() { alert('Bar!'); } );
             NexoAPI.events.addAction( 'test', function() { alert('Baz!'); } );
             
             // Remove the first one
             NexoAPI.events.removeAction( 'test', 'test_1' );
             
             // Do the remaining test actions
             NexoAPI.events.doAction( 'test' );
             
             
             // Add a filter somewhere
             NexoAPI.events.addFilter('filterOptions',function(options) {
             // Do stuff here to modify variable options
             return options;
             } );
             
             // Use the filter here
             options = NexoAPI.events.applyFilters('filterOptions',options);
             
             */

            NexoAPI.events = {
                /**
                 * Implement a WordPress-link Hook System for Javascript 
                 * TODO: Change 'tag' to 'args', allow number (priority), string (tag), object (priority+tag)
                 */

                hooks: {action: {}, filter: {}},
                addAction: function(action, callable, tag) {
                    NexoAPI.events.addHook('action', action, callable, tag);
                },
                addFilter: function(action, callable, tag) {
                    NexoAPI.events.addHook('filter', action, callable, tag);
                },
                doAction: function(action, args) {
                    NexoAPI.events.doHook('action', action, null, args);
                },
                applyFilters: function(action, value, args) {
                    return NexoAPI.events.doHook('filter', action, value, args);
                },
                removeAction: function(action, tag) {
                    NexoAPI.events.removeHook('action', action, tag);
                },
                removeFilter: function(action, tag) {
                    NexoAPI.events.removeHook('filter', action, tag);
                },
                addHook: function(hookType, action, callable, tag) {
                    if (undefined == NexoAPI.events.hooks[hookType][action]) {
                        NexoAPI.events.hooks[hookType][action] = [];
                    }
                    var hooks = NexoAPI.events.hooks[hookType][action];
                    if (undefined == tag) {
                        tag = action + '_' + hooks.length;
                    }
                    NexoAPI.events.hooks[hookType][action].push({tag: tag, callable: callable});
                },
                doHook: function(hookType, action, value, args) {
                    if (undefined != NexoAPI.events.hooks[hookType][action]) {
                        var hooks = NexoAPI.events.hooks[hookType][action];
                        for (var i = 0; i < hooks.length; i++) {
                            if ('action' == hookType) {
                                hooks[i].callable(args);
                            } else {
                                value = hooks[i].callable(value, args);
                            }
                        }
                    }
                    if ('filter' == hookType) {
                        return value;
                    }
                },
                removeHook: function(hookType, action, tag) {
                    if (undefined != NexoAPI.events.hooks[hookType][action]) {
                        var hooks = NexoAPI.events.hooks[hookType][action];
                        for (var i = hooks.length - 1; i >= 0; i--) {
                            if (undefined == tag || tag == hooks[i].tag)
                                hooks.splice(i, 1);
                        }
                    }
                }
            }
            /**
             * Money format
             * @param int amount
             * @return string
             **/

            NexoAPI.Format = function(int) {
                return numeral(int).format('0,0.00');
            };

            /**
             * Print specific dom element
             * @param object
             * @return void
             **/

            NexoAPI.PrintElement = function(elem) {
                NexoAPI.Popup($(elem).html());
            };

            /**
             * Nexo Customer parseFloat
             * @params val
             * @return val
             **/

            NexoAPI.ParseFloat = function(val) {
                if (typeof val == 'string') {
                    return parseFloat(parseFloat(val).toFixed(2))
                } else if (typeof val == 'number') {
                    return parseFloat(val.toFixed(2));
                } else {
                    return val;
                }
            }

            /** 
             * Popup Print dialog
             * @param string data
             * @return bool
             **/

            NexoAPI.Popup = function(data) {
                var mywindow = window.open('', 'my div', 'height=400,width=600');
                mywindow.document.write('<html><head><title>Shoezie World &rsaquo; Proceed a sale &mdash; NexoPOS</title>');
                mywindow.document.write('<link rel="stylesheet" href="http://demo-nexopos.tendoo.org/public/modules/nexo/bower_components/bootstrap/dist/css/bootstrap.min.css" type="text/css" />');
                mywindow.document.write('</head><body >');
                mywindow.document.write(data);
                mywindow.document.write('</body></html>');

                mywindow.document.close(); // necessary for IE >= 10
                mywindow.focus(); // necessary for IE >= 10

                setTimeout(function() {
                    mywindow.print();
                    // mywindow.close();
                }, 500);

                return true;
            };

            /**
             * Bind Print item
             *
             **/

            NexoAPI.BindPrint = function() {
                $('[print-item]').bind('click', function() {
                    NexoAPI.PrintElement($(this).attr('print-item'));
                });
            }

            /**
             * Currency Position
             **/

            NexoAPI.CurrencyPosition = function(amount) {
                return '$ ' + amount + ' ';
            }

            /**
             * Currency Position + Money Format
             **/

            NexoAPI.DisplayMoney = function(amount) {
                return NexoAPI.CurrencyPosition(NexoAPI.Format(parseFloat(amount)));
            }



            var NexoSound = 'http://demo-nexopos.tendoo.org/public//modules/nexo/sound/sound-';

            $(document).ready(function(e) {
                // @since 2.6.1

                NexoAPI.Bootbox = function() {
                    NexoAPI.Sound(2);
                    return bootbox;
                }

                NexoAPI.Notify = function() {
                    NexoAPI.Sound(1);
                    return tendoo.notify;
                }

                NexoAPI.Sound = function(sound_index) {
                    var SoundEnabled = 'enable';
                    if ((SoundEnabled.length != 0 || SoundEnabled == 'enable') && SoundEnabled != 'disable') {
                        var music = new buzz.sound(NexoSound + sound_index, {
                            formats: ["mp3"]
                        });
                        music.play();
                    }
                }

                NexoAPI.BindPrint();

                $(".knob").knob({
                    /*change : function (value) {
                     //console.log("change : " + value);
                     },
                     release : function (value) {
                     console.log("release : " + value);
                     },
                     cancel : function () {
                     console.log("cancel : " + this.value);
                     },*/
                    draw: function() {

                        // "tron" case
                        if (this.$.data('skin') == 'tron') {

                            var a = this.angle(this.cv)  // Angle
                                    , sa = this.startAngle          // Previous start angle
                                    , sat = this.startAngle         // Start angle
                                    , ea                            // Previous end angle
                                    , eat = sat + a                 // End angle
                                    , r = true;

                            this.g.lineWidth = this.lineWidth;

                            this.o.cursor
                                    && (sat = eat - 0.3)
                                    && (eat = eat + 0.3);

                            if (this.o.displayPrevious) {
                                ea = this.startAngle + this.angle(this.value);
                                this.o.cursor
                                        && (sa = ea - 0.3)
                                        && (ea = ea + 0.3);
                                this.g.beginPath();
                                this.g.strokeStyle = this.previousColor;
                                this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false);
                                this.g.stroke();
                            }

                            this.g.beginPath();
                            this.g.strokeStyle = r ? this.o.fgColor : this.fgColor;
                            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false);
                            this.g.stroke();

                            this.g.lineWidth = 2;
                            this.g.beginPath();
                            this.g.strokeStyle = this.o.fgColor;
                            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
                            this.g.stroke();

                            return false;
                        }
                    }
                });
            });
        </script>
        <script type="text/javascript">
            "use strict";

            var NexoSMS = new Object;
            NexoSMS.__CustomerNumber = '';
            NexoSMS.__SendSMSInvoice = null;
            NexoSMS.__CustomerName = '';

            /**
             * Set customer Number
             **/

            NexoAPI.events.addAction('select_customer', function(data) {
                if (_.isObject(data)) {
                    NexoSMS.__CustomerNumber = data[0].TEL;
                    NexoSMS.__CustomerName = data[0].NOM
                }
            });

            /**
             * Display Toggle
             **/

            NexoAPI.events.addFilter('pay_box_footer', function(data) {
                return 	data + '<input type="checkbox"  name="send_sms" send-sms-invoice data-toggle="toggle" data-width="150" data-height="35">';
            });

            /**
             * Load Paybox
             **/

            NexoAPI.events.addAction('pay_box_loaded', function(data) {
                $('[send-sms-invoice]').bootstrapToggle({
                    on: 'Activate SMS',
                    off: 'Disable SMS'
                });

                // Ask whether to change customer number

                $('[send-sms-invoice]').bind('change', function() {
                    if (typeof $(this).attr('checked') != 'undefined') {
                        NexoAPI.Bootbox().prompt({
                            title: "Please set the number to use for bills by SMS",
                            value: typeof NexoSMS.__CustomerNumber != 'undefined' ? NexoSMS.__CustomerNumber : '',
                            callback: function(result) {
                                if (result !== null) {
                                    NexoSMS.__CustomerNumber = result;
                                }
                            }
                        });
                    }
                });
            });

            /**
             * Before Subiting order
             **/

            NexoAPI.events.addAction('submit_order', function() {
                NexoSMS.__SendSMSInvoice = typeof $('[send-sms-invoice]').attr('checked') != 'undefined' ? true : false;
            })

            /** 
             * When Cart is Reset
             **/

            NexoAPI.events.addAction('reset_cart', function(v2Checkout) {
                NexoSMS.__CustomerNumber = '';
                NexoSMS.__SendSMSInvoice = null;
            });
        </script>
        <script type="text/javascript">

            "use strict";

            tendoo.base_url = 'http://demo-nexopos.tendoo.org/';
            tendoo.site_url = 'http://demo-nexopos.tendoo.org//';
            tendoo.dashboard_url = 'http://demo-nexopos.tendoo.org/dashboard';
            tendoo.current_url = 'http://demo-nexopos.tendoo.org/dashboard/stores/4/nexo/registers/__use/default';
            tendoo.index_url = '';
            tendoo.form_expire = '1473169996';
            tendoo.user = {
                id: 4}
            tendoo.csrf_field_name = 'csrf_secure';

            tendoo.csrf_field_value = 'ab00fa7ee41e553011ef081d2071aafb';

            tendoo.csrf_data = {
                'csrf_secure': 'ab00fa7ee41e553011ef081d2071aafb'
            };
            // Date Object
            tendoo.date = new Date();
            tendoo.now = function() {
                this.add_zero = function(i) {
                    if (i < 10) {
                        i = "0" + i;
                    }
                    return i;
                }
                var d = this.add_zero(tendoo.date.getDate()),
                        m = this.add_zero(tendoo.date.getMonth()),
                        y = this.add_zero(tendoo.date.getFullYear()),
                        s = this.add_zero(tendoo.date.getSeconds()),
                        h = this.add_zero(tendoo.date.getHours()),
                        i = this.add_zero(tendoo.date.getMinutes());
                return y + '-' + m + '-' + d + 'T' + h + ':' + i + ':' + s;
            };
            // Gui Options
            tendoo.options_data = {
                gui_saver_expiration_time: tendoo.form_expire,
                gui_saver_option_namespace: null,
                gui_saver_use_namespace: false,
                user_id: tendoo.user.id,
                gui_json: true
            }

            // Tendoo options
            tendoo.options = new function() {
                var $this = this;
                var save_slug;
                this.set = function(key, value, user_meta) {
                    if (typeof user_meta != 'undefined') {
                        save_slug = 'save_user_meta';
                    } else {
                        save_slug = 'save';
                    }
                    value = (typeof value == 'object') ? JSON.stringify(value) : value
                    var post_data = _.object([key], [value]);
                    // Add CSRF Secure for POST Ajax
                    tendoo.options_data = _.extend(tendoo.options_data, tendoo.csrf_data);
                    tendoo.options_data = _.extend(tendoo.options_data, post_data);

                    $.ajax('http://demo-nexopos.tendoo.org/dashboard/options/' + save_slug, {
                        data: tendoo.options_data,
                        type: 'POST',
                        beforeSend: function() {
                            if (_.isFunction($this.beforeSend)) {
                                $this.beforeSend();
                            }
                        },
                        success: function(data) {
                            if (_.isFunction($this.success)) {
                                $this.success(data);
                            }
                        }
                    });
                };
                this.merge = function(key, value, user_meta) {
                    if (typeof user_meta != 'undefined') {
                        save_slug = 'merge_user_meta';
                    } else {
                        save_slug = 'merge';
                    }
                    var post_data = _.object([key], [value]);
                    tendoo.options_data = _.extend(tendoo.options_data, tendoo.csrf_data);
                    tendoo.options_data = _.extend(tendoo.options_data, post_data);
                    $.ajax('http://demo-nexopos.tendoo.org/dashboard/options/' + save_slug, {
                        data: tendoo.options_data,
                        type: 'POST',
                        beforeSend: function() {
                            if (_.isFunction($this.beforeSend)) {
                                $this.beforeSend();
                            }
                        },
                        success: function(data) {
                            if (_.isFunction($this.success)) {
                                $this.success(data);
                            }
                        }
                    });
                };
                this.get = function(key, callback) {
                    var post_data = _.object(['option_key'], [key]);
                    tendoo.options_data = _.extend(tendoo.options_data, tendoo.csrf_data);
                    tendoo.options_data = _.extend(tendoo.options_data, post_data);
                    $.ajax('http://demo-nexopos.tendoo.org/dashboard/options/get', {
                        data: tendoo.options_data,
                        type: 'POST',
                        beforeSend: function() {
                            // $this.beforeSend();
                        },
                        success: function(data) {
                            if (_.isFunction(callback)) {
                                callback(data);
                            }
                        }
                    });
                }
                this.beforeSend = function(callback) {
                    this.beforeSend = callback;
                    return this;
                };
                this.success = function(callback) {
                    this.success = callback
                    return this;
                }
            }
            tendoo.loader = new function() {
                this.int = 0;
                this.timeOutToClose;
                this.show = function() {

                    this.int++;

                    if ($('#canvasLoader').length > 0) {
                        clearTimeout(this.timeOutToClose);
                    } else {
                        if (this.int == 1) {
                            var cl = new CanvasLoader('tendoo-spinner');
                            cl.setColor('#ffffff'); // default is '#000000'
                            cl.setDiameter(35); // default is 40
                            cl.setDensity(56); // default is 40
                            cl.setSpeed(3); // default is 2
                            cl.show(); // Hidden by default
                            $('#tendoo-spinner').fadeIn(500);
                        }
                    }
                }
                this.hide = function() {

                    this.int--;

                    if (this.int == 0) {
                        this.timeOutToClose = setTimeout(function() {
                            $('#tendoo-spinner').fadeOut(500, function() {
                                $(this).html('').show();
                            })
                        }, 500);
                    }
                }
            }
            /**
             * Tendoo Tools
             * @since 3.0.5
             **/

            tendoo.tools = new Object();
            tendoo.tools.remove_tags = function(string) {
                return string.replace(/(<([^>]+)>)/ig, "");
            };
            $(document).ready(function() {
                $(document).ajaxComplete(function() {
                    tendoo.loader.hide();
                });
                $(document).ajaxError(function() {
                    tendoo.loader.hide();
                });
                $(document).ajaxSend(function() {
                    tendoo.loader.show();
                });

                // Add CSRF Protection to each request
                $.ajaxPrefilter(function(options, originalOptions, jqXHR) {
                    if (typeof originalOptions.type != 'undefined') {
                        if (originalOptions.type.toUpperCase() === 'POST' || options.type.toUpperCase() === 'POST') {
                            if (typeof originalOptions.data == 'string') {
                                options.data = $.param(_.extend(tendoo.csrf_data, $.parseParams(originalOptions.data)));
                            } else if (typeof originalOptions.data == 'object') {
                                // Fix Grocery Crud issue while upload
                                if (typeof options.multipart == 'undefined') {
                                    options.data = $.param(_.extend(tendoo.csrf_data, originalOptions.data));
                                }
                            }
                        }
                    }
                    // Add header @since 3.1.1
                    if (options.beforeSend) {
                        var oldBeforeSend = options.beforeSend;
                    }

                    options.beforeSend = function(xhr, settings) {
                        if (typeof oldBeforeSend != 'undefined') {
                            oldBeforeSend(xhr, settings);
                        }
                        xhr.setRequestHeader('X-API-KEY', 'y1zmvEsOFr8H44IfCcVzqTpODosxDXbcZLyvp1j5');
                    }
                });
            });
        </script>            <script type="text/javascript" src="./Shoezie World › Proceed a sale — NexoPOS_files/jmarquee.js"></script>
        <script src="./Shoezie World › Proceed a sale — NexoPOS_files/slick.js"></script>
        <link rel="stylesheet" href="./Shoezie World › Proceed a sale — NexoPOS_files/slick.css" media="screen">
        <link rel="stylesheet" href="./Shoezie World › Proceed a sale — NexoPOS_files/slick-theme.css" media="screen">

        <title>Shoezie World › Proceed a sale — NexoPOS</title>
    </head>
    <body class="skin-green sidebar-collapse fixed sidebar-mini">
        <div class="wrapper">
            <header class="main-header"> 

                <!-- Logo --> 
                <a href="http://demo-nexopos.tendoo.org/dashboard" class="logo"> 
                    <!-- mini logo for sidebar mini 50x50 pixels --> 
                    <span class="logo-mini"><img id="tendoo-logo" xss="removed" src="./Shoezie World › Proceed a sale — NexoPOS_files/logo_minim.png"></span> 
                    <!-- logo for regular state and mobile devices --> 
                    <span class="logo-lg"><b>Tend</b>oo</span> </a> 

                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation"> 
                    <!-- Sidebar toggle button--> 
                    <a href="http://demo-nexopos.tendoo.org/dashboard/stores/4/nexo/registers/__use/default#" class="sidebar-toggle" data-toggle="offcanvas"> <span class="sr-only">Toggle navigation</span> </a> 
                    <div class="pull-left" id="tendoo-spinner" style="margin-top: 7px; margin-left: 7px; display: block;"></div>
                    <!-- Navbar Right Menu -->
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- Messages: style can be found in dropdown.less-->
                            <li class="messages-menu">
                                <a href="http://demo-nexopos.tendoo.org/dashboard/nexo/stores/all" title="Manage Stores"> 
                                    <i class="fa fa-home"></i>
                                </a>
                            </li>
                            <li class="dropdown messages-menu">
                                <a href="http://demo-nexopos.tendoo.org/dashboard/stores/4/nexo/registers/__use/default#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true"> 
                                    <i class="fa fa-cubes"></i>
                                    Stores    </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <!-- inner menu: contains the actual data -->
                                        <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 200px;"><ul class="menu" style="overflow: hidden; width: 100%; height: 200px;">
                                                <li> 
                                                    <a href="http://demo-nexopos.tendoo.org/dashboard/stores/1"> 
                                                        <i class="fa fa-cube text-default"></i> 
                                                        Perfumery Store					</a> 
                                                </li>
                                                <li> 
                                                    <a href="http://demo-nexopos.tendoo.org/dashboard/stores/2"> 
                                                        <i class="fa fa-cube text-default"></i> 
                                                        Clothes Store					</a> 
                                                </li>
                                                <li> 
                                                    <a href="http://demo-nexopos.tendoo.org/dashboard/stores/3"> 
                                                        <i class="fa fa-cube text-default"></i> 
                                                        High Tech Home					</a> 
                                                </li>
                                                <li> 
                                                    <a href="http://demo-nexopos.tendoo.org/dashboard/stores/4"> 
                                                        <i class="fa fa-cube text-default"></i> 
                                                        Shoezie World					</a> 
                                                </li>
                                            </ul><div class="slimScrollBar" style="width: 3px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px; background: rgb(0, 0, 0);"></div><div class="slimScrollRail" style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div></div>
                                    </li>
                                </ul>
                            </li>
                            <!-- Notifications: style can be found in dropdown.less -->
                            <li class="dropdown notifications-menu"> <a href="http://demo-nexopos.tendoo.org/dashboard/stores/4/nexo/registers/__use/default#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-bell-o"></i> 
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">You have 0 notices </li>
                                    <li> 
                                        <!-- inner menu: contains the actual data -->
                                        <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 200px;"><ul class="menu" style="overflow: hidden; width: 100%; height: 200px;">
                                            </ul><div class="slimScrollBar" style="width: 3px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px; background: rgb(0, 0, 0);"></div><div class="slimScrollRail" style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div></div>
                                    </li>
                                    <!-- <li class="footer"><a href="#">View all</a></li> -->
                                </ul>
                            </li>

                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu"> <a href="http://demo-nexopos.tendoo.org/dashboard/stores/4/nexo/registers/__use/default#" class="dropdown-toggle" data-toggle="dropdown"> 
                                    <img class="img-circle" alt="admin" src="./Shoezie World › Proceed a sale — NexoPOS_files/85afc2a8cb3f83866c92aec497b3feb6" width="20">
                                    <span class="hidden-xs">John Doe</span> </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header"> 
                                        <img class="img-circle" alt="admin" src="./Shoezie World › Proceed a sale — NexoPOS_files/85afc2a8cb3f83866c92aec497b3feb6">
                                        <p>John Doe</p>
                                    </li>
                                    <!-- Menu Body -->
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left"> <a href="http://demo-nexopos.tendoo.org/dashboard/users/profile" class="btn btn-default btn-flat">Profile</a> </div>
                                        <div class="pull-right"> <a href="http://demo-nexopos.tendoo.org/sign-out?redirect=http://demo-nexopos.tendoo.org/dashboard/stores/4/nexo/registers/__use/default" class="btn btn-default btn-flat">Sign Out</a> </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>

            <aside class="main-sidebar"> 
                <!-- sidebar: style can be found in sidebar.less -->
                <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 547px;"><section class="sidebar" style="height: 547px; overflow: hidden; width: auto;"> 
                        <!-- Sidebar user panel -->
                        <!-- search form -->
                        <!-- 
                        <form action="#" method="get" class="sidebar-form">
                          <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Search..."/>
                            <span class="input-group-btn">
                            <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span> </div>
                        </form>
                        -->
                        <!-- /.search form --> 
                        <!-- sidebar menu: : style can be found in sidebar.less -->
                        <ul class="sidebar-menu">
                            <li class="  namespace-store-dashboard">
                                <a href="http://demo-nexopos.tendoo.org/dashboard/stores/4"> 
                                    <i class="fa fa-dashboard"></i> 
                                    <span>Dashboard</span> 
                                </a>
                            </li>
                            <li class=" active namespace-caisse">
                                <a href="http://demo-nexopos.tendoo.org/dashboard/stores/4/nexo/registers/__use/default"> 
                                    <i class="fa fa-shopping-cart"></i> 
                                    <span>Open POS</span> 
                                </a>
                            </li>
                            <li class="  namespace-sales">
                                <a href="http://demo-nexopos.tendoo.org/dashboard/stores/4/nexo/commandes/lists"> 
                                    <i class="fa fa-shopping-basket"></i> 
                                    <span>Sales</span> 
                                </a>
                            </li>
                            <li class="treeview  namespace-arrivages">
                                <a href="javascript:void(0)" class=""> 
                                    <i class="fa fa-archive"></i> 
                                    <span>Inventory</span>
                                    <i class="fa fa-angle-left pull-right"></i>

                                </a>
                                <ul class="treeview-menu">
                                    <li> 
                                        <a href="http://demo-nexopos.tendoo.org/dashboard/stores/4/nexo/arrivages/lists">
                                            <span>Deliveries List</span>
                                        </a> 
                                    </li>	
                                    <li> 
                                        <a href="http://demo-nexopos.tendoo.org/dashboard/stores/4/nexo/arrivages/add">
                                            <span>New delivery</span>
                                        </a> 
                                    </li>	
                                    <li> 
                                        <a href="http://demo-nexopos.tendoo.org/dashboard/stores/4/nexo/produits/lists">
                                            <span>Items List</span>
                                        </a> 
                                    </li>	
                                    <li> 
                                        <a href="http://demo-nexopos.tendoo.org/dashboard/stores/4/nexo/produits/lists/add">
                                            <span>Add Item</span>
                                        </a> 
                                    </li>	
                                    <li> 
                                        <a href="http://demo-nexopos.tendoo.org/dashboard/stores/4/nexo/rayons/lists">
                                            <span>List of radius</span>
                                        </a> 
                                    </li>	
                                    <li> 
                                        <a href="http://demo-nexopos.tendoo.org/dashboard/stores/4/nexo/rayons/lists/add">
                                            <span>Add Radius</span>
                                        </a> 
                                    </li>	
                                    <li> 
                                        <a href="http://demo-nexopos.tendoo.org/dashboard/stores/4/nexo/categories/lists">
                                            <span>Categories List</span>
                                        </a> 
                                    </li>	
                                    <li> 
                                        <a href="http://demo-nexopos.tendoo.org/dashboard/stores/4/nexo/categories/lists/add">
                                            <span>Add a category</span>
                                        </a> 
                                    </li>	
                                </ul>
                            </li>
                            <li class="treeview  namespace-vendors">
                                <a href="javascript:void(0)" class=""> 
                                    <i class="fa fa-truck"></i> 
                                    <span>Suppliers</span>
                                    <i class="fa fa-angle-left pull-right"></i>

                                </a>
                                <ul class="treeview-menu">
                                    <li> 
                                        <a href="http://demo-nexopos.tendoo.org/dashboard/stores/4/nexo/fournisseurs/lists">
                                            <span>Suppliers List</span>
                                        </a> 
                                    </li>	
                                    <li> 
                                        <a href="http://demo-nexopos.tendoo.org/dashboard/stores/4/nexo/fournisseurs/lists/add">
                                            <span>Add a supplier</span>
                                        </a> 
                                    </li>	
                                </ul>
                            </li>
                            <li class="treeview  namespace-clients">
                                <a href="javascript:void(0)" class=""> 
                                    <i class="fa fa-users"></i> 
                                    <span>Customers</span>
                                    <i class="fa fa-angle-left pull-right"></i>

                                </a>
                                <ul class="treeview-menu">
                                    <li> 
                                        <a href="http://demo-nexopos.tendoo.org/dashboard/stores/4/nexo/clients/lists">
                                            <span>Customers List</span>
                                        </a> 
                                    </li>	
                                    <li> 
                                        <a href="http://demo-nexopos.tendoo.org/dashboard/stores/4/nexo/clients/lists/add">
                                            <span>Add a customer</span>
                                        </a> 
                                    </li>	
                                    <li> 
                                        <a href="http://demo-nexopos.tendoo.org/dashboard/stores/4/nexo/clients/groups/list">
                                            <span>Groups</span>
                                        </a> 
                                    </li>	
                                    <li> 
                                        <a href="http://demo-nexopos.tendoo.org/dashboard/stores/4/nexo/clients/groups/list/add">
                                            <span>Add a group</span>
                                        </a> 
                                    </li>	
                                </ul>
                            </li>
                            <li class="treeview  namespace-rapports">
                                <a href="javascript:void(0)" class=""> 
                                    <i class="fa fa-bar-chart"></i> 
                                    <span>Reports</span>
                                    <i class="fa fa-angle-left pull-right"></i>

                                </a>
                                <ul class="treeview-menu">
                                    <li> 
                                        <a href="http://demo-nexopos.tendoo.org/dashboard/stores/4/nexo_premium/Controller_Best_of">
                                            <span>Best Sales</span>
                                        </a> 
                                    </li>	
                                    <li> 
                                        <a href="http://demo-nexopos.tendoo.org/dashboard/stores/4/nexo/rapports/journalier">
                                            <span>Daily Sales</span>
                                        </a> 
                                    </li>	
                                    <li> 
                                        <a href="http://demo-nexopos.tendoo.org/dashboard/stores/4/nexo_premium/Controller_Mouvement_Annuel_Tresorerie">
                                            <span>Cash flow</span>
                                        </a> 
                                    </li>	
                                    <li> 
                                        <a href="http://demo-nexopos.tendoo.org/dashboard/stores/4/nexo_premium/Controller_Stats_Des_Ventes">
                                            <span>Annual Sales</span>
                                        </a> 
                                    </li>	
                                    <li> 
                                        <a href="http://demo-nexopos.tendoo.org/dashboard/stores/4/nexo_premium/Controller_Stats_Caissier">
                                            <span>Cashiers performance</span>
                                        </a> 
                                    </li>	
                                    <li> 
                                        <a href="http://demo-nexopos.tendoo.org/dashboard/stores/4/nexo_premium/Controller_Stats_Clients">
                                            <span>Customers Statistics</span>
                                        </a> 
                                    </li>	
                                    <li> 
                                        <a href="http://demo-nexopos.tendoo.org/dashboard/stores/4/nexo_premium/Controller_Fiche_De_Suivi">
                                            <span>Inventory tracking sheet</span>
                                        </a> 
                                    </li>	
                                </ul>
                            </li>
                            <li class="treeview  namespace-factures">
                                <a href="javascript:void(0)" class=""> 
                                    <i class="fa fa-sticky-note-o"></i> 
                                    <span>Expenses</span>
                                    <i class="fa fa-angle-left pull-right"></i>

                                </a>
                                <ul class="treeview-menu">
                                    <li> 
                                        <a href="http://demo-nexopos.tendoo.org/dashboard/stores/4/nexo_premium/Controller_Factures/list">
                                            <span>Expenses List</span>
                                        </a> 
                                    </li>	
                                    <li> 
                                        <a href="http://demo-nexopos.tendoo.org/dashboard/stores/4/nexo_premium/Controller_Factures/add">
                                            <span>New Expense</span>
                                        </a> 
                                    </li>	
                                </ul>
                            </li>
                            <li class="  namespace-nexo_settings">
                                <a href="javascript:void()"> 
                                    <i class="fa fa-cogs"></i> 
                                    <span>Store Settings</span> 
                                </a>
                            </li>
                        </ul>
                    </section><div class="slimScrollBar" style="width: 3px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 547px; background: rgba(0, 0, 0, 0.2);"></div><div class="slimScrollRail" style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div></div>
                <!-- /.sidebar --> 
            </aside>
            <!-- 
            Library : GUI-V2
            Version : 1.1
            Description : Provide simple UI manager
            Tendoo Version Required : 1.5
            -->
            <div class="content-wrapper" style="min-height: 548px;">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Shoezie World › Proceed a sale — NexoPOS    <small></small>
                        <small class="pull-right" id="cart-date" style="line-height: 30px;">14:56:59</small></h1>
                    <!--
                    <ol class="breadcrumb">
                      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                      <li class="active">Dashboard</li>
                    </ol>
                    -->
                </section>    
                <div class="content">
                    <div class="box collapse cart-options" id="collapseExample">
                        <div class="box-header">Filter Categories</div>
                        <div class="box-body categories_dom_wrapper">
                        </div>
                        <div class="box-footer">
                            <button class="btn btn-primary close-item-options pull-right">Hide options</button>
                        </div>
                    </div>   
                    <div class="row gui-row-tag">
                        <div class="meta-row col-lg-6 col-md-6">
                            <div class="box box-primary direct-chat direct-chat-primary" id="cart-details-wrapper" style="visibility: visible;">
                                <div class="box-header with-border" id="cart-header">
                                    <!--<h3 class="box-title">
                                        Checkout        </h3>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-sm btn-primary cart-add-customer"><i class="fa fa-user"></i> Add a customer</button>
                                    </div>-->
                                    <form action="http://demo-nexopos.tendoo.org/dashboard/stores/4/nexo/registers/__use/default#" method="post">
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">Please choose a customer</span>
                                            <div class="btn-group bootstrap-select input-group-btn form-control customers-list dropdown-bootstrap"><button type="button" class="btn dropdown-toggle btn-default" data-toggle="dropdown" title="Walkin Customer"><span class="filter-option pull-left">Walkin Customer</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button><div class="dropdown-menu open"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off"></div><ul class="dropdown-menu inner" role="menu"><li data-original-index="0" class="selected"><a tabindex="0" class="" style="" data-tokens="null"><span class="text">Walkin Customer</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li></ul></div><select data-live-search="true" name="customer_id" placeholder="Veuillez choisir un client" class="form-control customers-list dropdown-bootstrap" tabindex="-98" change-bound="true">

                                                    <option value="1" selected="selected">Walkin Customer</option></select></div>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-primary cart-add-customer" bound="true"><i class="fa fa-user"></i> Add a customer</button>
                                            </span>
                                        </div>            
                                    </form>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <table class="table" id="cart-item-table-header">
                                        <thead>
                                            <tr class="active">
                                                <td width="210" class="text-left">Items</td>
                                                <td width="130" class="text-center">Unit Price</td>
                                                <td width="145" class="text-center">quantity</td>
                                                <td width="115" class="text-right">Total Price</td>
                                            </tr>
                                        </thead>
                                    </table>
                                    <div class="direct-chat-messages" id="cart-table-body" style="padding: 0px; height: 193px;">
                                        <table class="table" style="margin-bottom:0;">                
                                            <tbody><tr id="cart-table-notice"><td colspan="4">Please add an item</td></tr></tbody>
                                        </table>
                                    </div>
                                    <table class="table" id="cart-details">
                                        <tfoot>
                                            <tr class="active">
                                                <td width="230" class="text-right"></td>
                                                <td width="130" class="text-right"></td>
                                                <td width="130" class="text-right">
                                                    Total:                    </td>
                                                <td width="110" class="text-right"><span id="cart-value">$ 0.00 </span></td>
                                            </tr>
                                            <tr class="active">
                                                <td colspan="2" width="380" class="text-right cart-discount-notice-area"></td>
                                                <td width="130" class="text-right">Discount</td>
                                                <td width="110" class="text-right"><span id="cart-discount">$ 0.00 </span></td>
                                            </tr>
                                            <tr class="success">
                                                <td width="230" class="text-right"></td>
                                                <td width="130" class="text-right"></td>
                                                <td width="130" class="text-right"><strong>Net Payable</strong></td>
                                                <td width="110" class="text-right"><span id="cart-topay">$ 0.00 </span></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer" id="cart-panel">
                                    <div class="btn-group btn-group-justified" role="group" aria-label="...">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-default btn-lg" id="cart-pay-button" style="margin-bottom:0px;">
                                                <i class="fa fa-money"></i>
                                                Pay            </button>
                                        </div>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-default btn-lg" id="cart-discount-button" style="margin-bottom:0px;">
                                                <i class="fa fa-gift"></i>
                                                Discount			</button>
                                        </div>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-default btn-lg" id="cart-return-to-order" style="margin-bottom:0px;"> <!-- btn-app  -->
                                                <i class="fa fa-remove"></i>
                                                Cancel			</button>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.box-footer--> 
                            </div>

                            <style type="text/css">
                                .expandable {
                                    width: 19%;
                                    overflow: hidden;
                                    white-space: nowrap;
                                    text-overflow: ellipsis;
                                    transition-property: width;
                                    transition-duration: 2s;
                                }
                                .item-grid-title {
                                    width: 19%;
                                    overflow: hidden;
                                    white-space: nowrap;
                                    text-overflow: ellipsis;
                                    transition-property: width;
                                    transition-duration: 2s;
                                }
                                .item-grid-price {
                                    width: 19%;
                                    overflow: hidden;
                                    white-space: nowrap;
                                    text-overflow: ellipsis;
                                    transition-property: width;
                                    transition-duration: 2s;
                                }
                                .expandable:hover{
                                    overflow: visible; 
                                    white-space: normal; 
                                    width: auto;
                                }
                                .shop-items:hover {
                                    background:#FFF;
                                    cursor:pointer;
                                    box-shadow:inset 5px 5px 100px #EEE;
                                }
                                .noselect {
                                    -webkit-touch-callout: none; /* iOS Safari */
                                    -webkit-user-select: none;   /* Chrome/Safari/Opera */
                                    -khtml-user-select: none;    /* Konqueror */
                                    -moz-user-select: none;      /* Firefox */
                                    -ms-user-select: none;       /* Internet Explorer/Edge */
                                    user-select: none;           /* Non-prefixed version, currently
                                                                    not supported by any browser */
                                }
                                .img-responsive {
                                    margin: 0 auto;
                                }
                                .modal-dialog {
                                    margin: 10px auto !important;
                                }

                                /**
                                 NexoPOS 2.7.1
                                **/

                                #cart-table-body .table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {
                                    border-bottom: 1px solid #f4f4f4;
                                    margin-bottom:-1px;
                                }
                                .box {
                                    border-top: 0px solid #d2d6de;
                                }
                            </style>        </div>
                        <div class="meta-row col-lg-6 col-md-6">
                            <div class="box box-primary direct-chat direct-chat-primary" id="product-list-wrapper" style="visibility: visible;">
                                <div class="box-header with-border">
                                    <form action="http://demo-nexopos.tendoo.org/dashboard/stores/4/nexo/registers/__use/default#" method="post" id="search-item-form">
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn btn-large btn-default">Search</button>
                                            </span>
                                            <input type="text" name="item_sku_barcode" placeholder="Barcode, SKU, product name or category ..." class="form-control">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button" alt="Note" data-set-note=""><i class="fa fa-pencil"></i> Note</button>
                                            </span>
                                        </div>
                                    </form>
                                </div>
                                <div class="box-header with-border cattegory-slider" style="padding:0px;">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-lg-1 col-md-1 hidden-sm text-center slick-button cat-prev" style="padding:0;border-right:solid 1px #EEE;"><i style="font-size:20px;line-height:40px;" class="fa fa-arrow-left"></i></div>
                                            <div class="col-lg-10 col-md-10 col-sm-12 add_slick_inside" style="padding:0;"><div class="slick slick-wrapper slick-initialized slick-slider"><div aria-live="polite" class="slick-list draggable"><div class="slick-track" style="opacity: 1; width: 15000px; transform: translate3d(0px, 0px, 0px);" role="listbox"><div data-cat-id="3" style="padding:0px 20px;font-size:20px;line-height:40px;border-right:solid 1px #EEE;margin-right:-1px;" class="text-center slick-item slick-slide slick-current slick-active" data-slick-index="0" aria-hidden="false" tabindex="-1" role="option" aria-describedby="slick-slide00">Simple M</div><div data-cat-id="6" style="padding:0px 20px;font-size:20px;line-height:40px;border-right:solid 1px #EEE;margin-right:-1px;" class="text-center slick-item slick-slide slick-active" data-slick-index="1" aria-hidden="false" tabindex="-1" role="option" aria-describedby="slick-slide01">Leathern W</div><div data-cat-id="9" style="padding:0px 20px;font-size:20px;line-height:40px;border-right:solid 1px #EEE;margin-right:-1px;" class="text-center slick-item slick-slide slick-active" data-slick-index="2" aria-hidden="false" tabindex="-1" role="option" aria-describedby="slick-slide02">Sport M</div></div></div></div></div>
                                            <div class="col-lg-1 col-md-1 hidden-sm text-center slick-button cat-next" style="padding:0;border-left:solid 1px #EEE;"><i style="font-size:20px;line-height:40px;" class="fa fa-arrow-right"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <style type="text/css">
                                    .slick-button:hover {
                                        background : #F2F2F2;
                                        cursor: pointer;
                                    }
                                    .slick-item:hover {
                                        box-shadow:inset 0px -3px 10px 5px #F2F2F2;
                                        cursor: pointer
                                    }
                                    .slick-item-active {
                                        background: #EEE
                                    }
                                </style>
                                <!--<div class="box-footer" id="search-product-code-bar" style="border-bottom:1px solid #EEE;">
                                    <form action="#" method="post" id="search-item-form">
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn btn-large btn-default">Search</button>
                                            </span>
                                            <input type="text" name="item_sku_barcode" placeholder="Barcodes or SKU..." class="form-control">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default item-list-settings" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                                <i class="fa fa-cogs"></i>
                                                Filter Categories                </button>
                                            </span>
                                                    </div>
                                    </form>
                                </div>-->
                                <!-- /.box-header -->
                                <div class="box-body" style="visibility: visible;">
                                    <div class="direct-chat-messages item-list-container" style="padding: 0px; height: 369px;">
                                        <div class="row" id="filter-list" style="padding-left:0px;padding-right:0px;margin-left:0px;margin-right:0px;"><div class="col-lg-2 col-md-3 col-xs-6 shop-items filter-add-product noselect text-center" data-codebar="645797" style=";padding:5px; border-right: solid 1px #DEDEDE;border-bottom: solid 1px #DEDEDE;" data-design="elza 32" data-category="3" data-sku="ez32" data-category-name="simple m"><img data-original="http://demo-nexopos.tendoo.org/public/upload/store_4/f1b1a-elza_32_rg_160.jpg" style="max-height: 64px; display: block;" class="img-responsive img-rounded lazy" src="./Shoezie World › Proceed a sale — NexoPOS_files/f1b1a-elza_32_rg_160.jpg"><div class="caption text-center" style="padding:2px;overflow:hidden;"><strong class="item-grid-title">Elza 32</strong><br><span class="align-center">$ 44.00 </span></div></div><div class="col-lg-2 col-md-3 col-xs-6 shop-items filter-add-product noselect text-center" data-codebar="992367" style=";padding:5px; border-right: solid 1px #DEDEDE;border-bottom: solid 1px #DEDEDE;" data-design="tedia" data-category="9" data-sku="tdia" data-category-name="sport m"><img data-original="http://demo-nexopos.tendoo.org/public/upload/store_4/4ff36-tedia_28_rg_160.jpg" style="max-height: 64px; display: block;" class="img-responsive img-rounded lazy" src="./Shoezie World › Proceed a sale — NexoPOS_files/4ff36-tedia_28_rg_160.jpg"><div class="caption text-center" style="padding:2px;overflow:hidden;"><strong class="item-grid-title">Tedia</strong><br><span class="align-center">$ 43.25 </span></div></div><div class="col-lg-2 col-md-3 col-xs-6 shop-items filter-add-product noselect text-center" data-codebar="517807" style=";padding:5px; border-right: solid 1px #DEDEDE;border-bottom: solid 1px #DEDEDE;" data-design="bergon" data-category="6" data-sku="bgon" data-category-name="leathern w"><img data-original="http://demo-nexopos.tendoo.org/public/upload/store_4/b7365-bergson_28_rg_160.jpg" style="max-height: 64px; display: block;" class="img-responsive img-rounded lazy" src="./Shoezie World › Proceed a sale — NexoPOS_files/b7365-bergson_28_rg_160.jpg"><div class="caption text-center" style="padding:2px;overflow:hidden;"><strong class="item-grid-title">Bergon</strong><br><span class="align-center">$ 42.85 </span></div></div><div class="col-lg-2 col-md-3 col-xs-6 shop-items filter-add-product noselect text-center" data-codebar="569123" style=";padding:5px; border-right: solid 1px #DEDEDE;border-bottom: solid 1px #DEDEDE;" data-design="bomplan" data-category="6" data-sku="bplan" data-category-name="leathern w"><img data-original="http://demo-nexopos.tendoo.org/public/upload/store_4/183ff-bomplan_40_rg_160.jpg" style="max-height: 64px; display: block;" class="img-responsive img-rounded lazy" src="./Shoezie World › Proceed a sale — NexoPOS_files/183ff-bomplan_40_rg_160.jpg"><div class="caption text-center" style="padding:2px;overflow:hidden;"><strong class="item-grid-title">BomPlan</strong><br><span class="align-center">$ 43.60 </span></div></div><div class="col-lg-2 col-md-3 col-xs-6 shop-items filter-add-product noselect text-center" data-codebar="351025" style=";padding:5px; border-right: solid 1px #DEDEDE;border-bottom: solid 1px #DEDEDE;" data-design="conso" data-category="6" data-sku="cso" data-category-name="leathern w"><img data-original="http://demo-nexopos.tendoo.org/public/upload/store_4/d955f-conso_96_rg_160.jpg" style="max-height: 64px; display: block;" class="img-responsive img-rounded lazy" src="./Shoezie World › Proceed a sale — NexoPOS_files/d955f-conso_96_rg_160.jpg"><div class="caption text-center" style="padding:2px;overflow:hidden;"><strong class="item-grid-title">Conso</strong><br><span class="align-center">$ 39.75 </span></div></div><div class="col-lg-2 col-md-3 col-xs-6 shop-items filter-add-product noselect text-center" data-codebar="110349" style=";padding:5px; border-right: solid 1px #DEDEDE;border-bottom: solid 1px #DEDEDE;" data-design="fredola" data-category="6" data-sku="fdla" data-category-name="leathern w"><img data-original="http://demo-nexopos.tendoo.org/public/upload/store_4/8af55-fredola_98_rg_160.jpg" style="max-height: 64px; display: block;" class="img-responsive img-rounded lazy" src="./Shoezie World › Proceed a sale — NexoPOS_files/8af55-fredola_98_rg_160.jpg"><div class="caption text-center" style="padding:2px;overflow:hidden;"><strong class="item-grid-title">Fredola</strong><br><span class="align-center">$ 48.50 </span></div></div></div>
                                    </div>
                                </div>
                                <div class="overlay" id="product-list-splash" style="display: none;">
                                    <i class="fa fa-refresh fa-spin"></i>
                                </div>
                            </div>
                            <style type="text/css">
                                .content-wrapper > .content {
                                    padding-bottom:0px;
                                }


                                /*  bootstrap tab */

                                div.bootstrap-tab {
                                    border-left: 1px #EEE solid;
                                    border-right: 1px #EEE solid;
                                    background: #FFF;
                                }
                                div.bootstrap-tab-container{
                                    z-index: 10;
                                    background-color: #ffffff;
                                    padding: 0 !important;
                                    background-clip: padding-box;
                                    opacity: 0.97;
                                    filter: alpha(opacity=97);
                                }
                                div.bootstrap-tab-menu{
                                    padding-right: 0;
                                    padding-left: 0;
                                    padding-bottom: 0;
                                    height: 242px;
                                }
                                div.bootstrap-tab-menu div.list-group{
                                    margin-bottom: 0;
                                }
                                div.bootstrap-tab-menu div.list-group>a{
                                    margin-bottom: -1px;
                                }
                                div.bootstrap-tab-menu div.list-group>a:nth-child(1){
                                    margin-top: -1px;
                                }
                                div.bootstrap-tab-menu div.list-group>a .glyphicon,

                                div.bootstrap-tab-menu div.list-group>a.active,
                                div.bootstrap-tab-menu div.list-group>a.active .glyphicon,
                                div.bootstrap-tab-menu div.list-group>a.active .fa{
                                    background-color:  #EEE; /** #9792e4;**/
                                    background-image: #EEE; /** #9792e4; **/
                                    color: #333;
                                    border: solid 1px #DDD;
                                }
                                div.bootstrap-tab-menu div.list-group>a.active:after{
                                    content: '';
                                    position: absolute;
                                    left: 100%;
                                    top: 50%;
                                    margin-top: -13px;
                                    border-left: 0;
                                    border-bottom: 13px solid transparent;
                                    border-top: 13px solid transparent;
                                    border-left: 10px solid #EEE; /** #9792e4; **/
                                }

                                div.bootstrap-tab-content{
                                    /** background-color: #ffffff; **/
                                    /* border: 1px solid #eeeeee; */
                                    padding-left: 0px;
                                    padding-top: 10px;
                                }

                                div.bootstrap-tab div.bootstrap-tab-content:not(.active){
                                    display: none;
                                }
                                .pay-box-container .list-group-item:last-child, .pay-box-container .list-group-item:first-child {
                                    border-radius: 0px !important;
                                    border-radius: 0px !important;
                                }
                            </style>
                            <script type="text/javascript">
            "use strict";


            var v2Checkout = new function() {

                this.ProductListWrapper = '#product-list-wrapper';
                this.CartTableBody = '#cart-table-body';
                this.ItemsListSplash = '#product-list-splash';
                this.CartTableWrapper = '#cart-details-wrapper';
                this.CartTableBody = '#cart-table-body';
                this.CartDiscountButton = '#cart-discount-button';
                this.ProductSearchInput = '#search-product-code-bar';
                this.ItemSettings = '.item-list-settings';
                this.ItemSearchForm = '#search-item-form';
                this.CartPayButton = '#cart-pay-button';
                this.CartCancelButton = '#cart-return-to-order';

                this.CartVATEnabled = false;
                this.CartVATPercent = 0
                if (this.CartVATPercent == '0') {
                    this.CartVATEnabled = false;
                }

                /**
                 * Show Product List Splash
                 **/

                this.showSplash = function(position) {
                    if (position == 'right') {
                        // Simulate Show Splash
                        $(this.ItemsListSplash).show();
                        $(this.ProductListWrapper).find('.box-body').css({'visibility': 'hidden'});
                    }
                };

                /**
                 * Hid Splash
                 **/

                this.hideSplash = function(position) {
                    if (position == 'right') {
                        // Simulate Show Splash
                        $(this.ItemsListSplash).hide();
                        $(this.ProductListWrapper).find('.box-body').css({'visibility': 'visible'});
                    }
                };

                /**
                 * Fix Product Height
                 **/

                this.fixHeight = function() {
                    // Height and Width
                    var headerHeight = parseInt($('.main-header').outerHeight());
                    var contentMargin = parseInt($('.content').css('padding-top'));
                    var contentHeader = parseInt($('.content-header').outerHeight(true));
                    // var windowHeight				=	parseInt( window.innerHeight < 500 ? 500 : window.innerHeight );
                    var wrapperHeight = parseInt($('.content-wrapper').css('min-height'));
                    var footerHeight = parseInt($('.main-footer').height());
                    var categorySliderHeight = parseInt($('.cattegory-slider').height());

                    // Col 2
                    var boxHeaderOuterHeight = parseInt($('.box-header.with-border').outerHeight(true));
                    $('.item-list-container').height(wrapperHeight - (
                            headerHeight +
                            contentMargin +
                            contentHeader +
                            boxHeaderOuterHeight +
                            footerHeight +
                            categorySliderHeight
                            ));

                    // Col 1

                    var cartHeader = parseInt($('#cart-header').outerHeight());
                    var cartTableHeader = parseInt($('#cart-item-table-header').height());
                    var cartTableFooter = parseInt($('#cart-details').height());
                    var cartPanel = parseInt($('#cart-panel').outerHeight());

                    $('#cart-table-body').height(wrapperHeight - (
                            cartHeader +
                            cartTableHeader +
                            cartTableFooter +
                            cartPanel +
                            // Common Height
                            headerHeight +
                            contentMargin +
                            contentHeader +
                            footerHeight
                            ));

                    /*var cartDetailsHeight			=	$( '#cart-details' ).outerHeight();
                     var cartPanelHeight				=	$( '#cart-panel' ).outerHeight();
                     var cartSearchHeight			=	$( '#cart-search-wrapper' ).outerHeight();
                     var cartHeader					=	$( '#cart-header' ).outerHeight();
                     var cartTableHeader				=	-9; // $( '#cart-item-table-header' ).outerHeight();
                     var col1Height					=	windowHeight - ( ( cartDetailsHeight + cartPanelHeight + cartSearchHeight + cartHeader + cartTableHeader ) + ( ( headerHeight + contentHeader + contentPadding ) * 2 ) );
                     $( this.CartTableBody ).height( col1Height );
                     // Col 2
                     var searchProductInputHeight	=	$( this.ProductSearchInput ).height();
                     var col2Height			=	windowHeight - ( -16 + ( headerHeight + contentHeader + contentPadding + searchProductInputHeight ) * 2 );
                     $( this.ProductListWrapper	).find( '.direct-chat-messages' ).height( col2Height );*/
                };

                /**
                 * Close item options
                 **/

                this.bindHideItemOptions = function() {
                    $('.close-item-options').bind('click', function() {
                        $(v2Checkout.ItemSettings).trigger('click');
                    });
                }

                /**
                 * Bind Add To Item
                 *
                 * @return void
                 **/

                this.bindAddToItems = function() {
                    $('#filter-list').find('.filter-add-product[data-category]').each(function() {
                        $(this).bind('click', function() {
                            var codebar = $(this).attr('data-codebar');
                            v2Checkout.fetchItem(codebar);
                        });
                    });
                };

                /**
                 * Bind Add Reduce Actions on Cart table items
                 **/

                this.bindAddReduceActions = function() {

                    $('#cart-table-body .item-reduce').each(function() {
                        $(this).bind('click', function() {
                            var parent = $(this).closest('tr');
                            _.each(v2Checkout.CartItems, function(value, key) {
                                if (typeof value != 'undefined') {
                                    if (value.CODEBAR == $(parent).data('item-barcode')) {
                                        value.QTE_ADDED--;
                                        // If item reach "0";
                                        if (parseInt(value.QTE_ADDED) == 0) {
                                            v2Checkout.CartItems.splice(key, 1);
                                        }
                                    }
                                }
                            });
                            v2Checkout.buildCartItemTable();
                        });
                    });

                    $('#cart-table-body .item-add').each(function() {
                        $(this).bind('click', function() {
                            var parent = $(this).closest('tr');
                            v2Checkout.fetchItem($(parent).data('item-barcode'), 1, true);
                        });
                    });
                };

                /**
                 * Bind Add by input
                 **/

                this.bindAddByInput = function() {
                    var currentInputValue = 0;
                    $('[name="shop_item_quantity"]').bind('focus', function() {
                        currentInputValue = $(this).val();
                    });
                    $('[name="shop_item_quantity"]').bind('change', function() {
                        var parent = $(this).closest('tr');
                        var value = $(this).val();
                        var codebar = $(parent).data('item-barcode');

                        if (value >= 0) {
                            v2Checkout.fetchItem(codebar, value, false);
                        } else {
                            $(this).val(currentInputValue);
                        }
                    });

                    // Bind Num padd
                    $('[name="shop_item_quantity"]').bind('click', function() {
                        v2Checkout.showNumPad($(this), 'Set the quantity to add');
                    });
                }

                /**
                 * Bind Add Note
                 * @since 2.7.3
                 **/

                this.bindAddNote = function() {
                    $('[data-set-note]').bind('click', function() {

                        var dom = '<h4 class="text-center">Add a note to the order</h4>' +
                                '<div class="form-group">' +
                                '<label for="exampleInputFile">Order Note</label>' +
                                '<textarea class="form-control" order_note rows="10"></textarea>' +
                                '<p class="help-block">This note will be attached to the current order.</p>' +
                                '</div>';

                        NexoAPI.Bootbox().confirm(dom, function(action) {
                            if (action) {
                                v2Checkout.CartNote = $('[order_note]').val();
                            }
                        });

                        $('[order_note]').val(v2Checkout.CartNote);
                    });
                };

                /**
                 * Bind Category Action 
                 * @since 2.7.1
                 **/

                this.bindCategoryActions = function() {
                    $('.slick-wrapper').remove(); // empty all
                    $('.add_slick_inside').html('<div class="slick slick-wrapper"></div>');
                    // Build New category wrapper @since 2.7.1
                    _.each(this.ItemsCategories, function(value, id) {
                        // New Categories List
                        $('.slick-wrapper').append('<div data-cat-id="' + id + '" style="padding:0px 20px;font-size:20px;line-height:40px;border-right:solid 1px #EEE;margin-right:-1px;" class="text-center slick-item">' + value + '</div>');

                        // Add category name to each item
                        if ($('[data-category="' + id + '"]').length > 0) {
                            $('[data-category="' + id + '"]').each(function() {
                                $(this).attr('data-category-name', value.toLowerCase());
                            });
                        }
                    });

                    $('.slick').slick({
                        infinite: false,
                        arrows: false,
                        slidesToShow: 4,
                        slidesToScroll: 4,
                        variableWidth: true
                    });

                    $('.slick-item').bind('click', function() {

                        var categories = new Array;
                        var proceed = true;

                        if ($(this).hasClass('slick-item-active')) {
                            proceed = false;
                        }

                        $('.slick-item.slick-item-active').each(function() {
                            $(this).removeClass('slick-item-active');
                        });

                        if (!$(this).hasClass('slick-item-active') && proceed == true) {
                            $(this).toggleClass('slick-item-active');
                            categories.push($(this).data('cat-id'));
                        }



                        v2Checkout.ActiveCategories = categories;
                        v2Checkout.filterItems(categories);
                    });

                    // Bind Next button
                    $('.cat-next').bind('click', function() {
                        $('.slick').slick('slickNext');
                    });
                    // Bind Prev button
                    $('.cat-prev').bind('click', function() {
                        $('.slick').slick('slickPrev');
                    });
                }

                /**
                 * Bind remove cart group discount
                 **/

                this.bindRemoveCartGroupDiscount = function() {
                    $('.btn.cart-group-discount').each(function() {
                        if (!$(this).hasClass('remove-action-bound')) {
                            $(this).addClass('remove-action-bound');
                            $(this).bind('click', function() {
                                NexoAPI.Bootbox().confirm('Do you want to disable group discount ?', function(action) {
                                    if (action == true) {
                                        v2Checkout.cartGroupDiscountReset();
                                        v2Checkout.refreshCartValues();
                                    }
                                })
                            });
                        }
                    });
                };

                /**
                 * Bind Remove Cart Remise
                 * Let use to cancel a discount directly from the cart table, when it has been added
                 **/

                this.bindRemoveCartRemise = function() {
                    $('.btn.cart-discount').each(function() {
                        if (!$(this).hasClass('remove-action-bound')) {
                            $(this).addClass('remove-action-bound');
                            $(this).bind('click', function() {
                                NexoAPI.Bootbox().confirm('Do you really like to cancel this discount?', function(action) {
                                    if (action == true) {
                                        v2Checkout.CartRemise = 0;
                                        v2Checkout.CartRemiseType = null;
                                        v2Checkout.CartRemiseEnabled = false;
                                        v2Checkout.CartRemisePercent = null;
                                        v2Checkout.refreshCartValues();
                                    }
                                })
                            });
                        }
                    });
                };

                /**
                 * Bind Remove Cart Ristourne
                 **/

                this.bindRemoveCartRistourne = function() {
                    $('.btn.cart-ristourne').each(function() {
                        if (!$(this).hasClass('remove-action-bound')) {
                            $(this).addClass('remove-action-bound');
                            $(this).bind('click', function() {
                                NexoAPI.Bootbox().confirm('Do you want to cancel this refund ?', function(action) {
                                    if (action == true) {
                                        v2Checkout.CartRistourne = 0;
                                        v2Checkout.CartRistourneEnabled = false;
                                        v2Checkout.refreshCartValues();
                                    }
                                })
                            });
                        }
                    });
                };

                /**
                 * Bind Add Discount
                 **/

                this.bindAddDiscount = function() {
                    var DiscountDom =
                            '<div id="discount-box-wrapper">' +
                            '<h4 class="text-center">Apply Discount<span class="discount_type"></h4><br>' +
                            '<div class="input-group input-group-lg">' +
                            '<span class="input-group-btn">' +
                            '<button class="btn btn-default percentage_discount" type="button">Percentage</button>' +
                            '</span>' +
                            '<input type="number" name="discount_value" class="form-control" placeholder="Define the amount or percentage here...">' +
                            '<span class="input-group-btn">' +
                            '<button class="btn btn-default flat_discount" type="button">Cash</button>' +
                            '</span>' +
                            '</div>' +
                            '<br>' +
                            '<div class="row">' +
                            '<div class="col-lg-12">' +
                            '<div class="row">' +
                            '<div class="col-lg-2 col-md-2 col-xs-2">' +
                            '<input type="button" class="btn btn-default btn-block btn-lg numpad7" value="7"/>' +
                            '</div>' +
                            '<div class="col-lg-2 col-md-2 col-xs-2">' +
                            '<input type="button" class="btn btn-default btn-block btn-lg numpad8" value="8"/>' +
                            '</div>' +
                            '<div class="col-lg-2 col-md-2 col-xs-2">' +
                            '<input type="button" class="btn btn-default btn-block btn-lg numpad9" value="9"/>' +
                            '</div>' +
                            '<div class="col-lg-6 col-md-6 col-xs-6">' +
                            '<input type="button" class="btn btn-warning btn-block btn-lg numpaddel" value="Go Back"/>' +
                            '</div>' +
                            '</div>' +
                            '<br>' +
                            '<div class="row">' +
                            '<div class="col-lg-2 col-md-2 col-xs-2">' +
                            '<input type="button" class="btn btn-default btn-block btn-lg numpad4" value="4"/>' +
                            '</div>' +
                            '<div class="col-lg-2 col-md-2 col-xs-2">' +
                            '<input type="button" class="btn btn-default btn-block btn-lg numpad5" value="5"/>' +
                            '</div>' +
                            '<div class="col-lg-2 col-md-2 col-xs-2">' +
                            '<input type="button" class="btn btn-default btn-block btn-lg numpad6" value="6"/>' +
                            '</div>' +
                            '<div class="col-lg-6 col-md-6 col-xs-6">' +
                            '<input type="button" class="btn btn-danger btn-block btn-lg numpadclear" value="Clear"/>' +
                            '</div>' +
                            '</div>' +
                            '<br>' +
                            '<div class="row">' +
                            '<div class="col-lg-2 col-md-2 col-xs-2">' +
                            '<input type="button" class="btn btn-default btn-block btn-lg numpad1" value="1"/>' +
                            '</div>' +
                            '<div class="col-lg-2 col-md-2 col-xs-2">' +
                            '<input type="button" class="btn btn-default btn-block btn-lg numpad2" value="2"/>' +
                            '</div>' +
                            '<div class="col-lg-2 col-md-2 col-xs-2">' +
                            '<input type="button" class="btn btn-default btn-block btn-lg numpad3" value="3"/>' +
                            '</div>' +
                            '</div>' +
                            '<br>' +
                            '<div class="row">' +
                            '<div class="col-lg-2 col-md-2 col-xs-2">' +
                            '<input type="button" class="btn btn-default btn-block btn-lg numpad00" value="00"/>' +
                            '</div>' +
                            '<div class="col-lg-4 col-md-6 col-xs-6">' +
                            '<input type="button" class="btn btn-default btn-block btn-lg numpad0" value="0"/>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>';

                    NexoAPI.Bootbox().confirm(DiscountDom, function(action) {
                        if (action == true) {
                            var value = $('[name="discount_value"]').val();

                            if (value == '' || value == '0') {
                                NexoAPI.Bootbox().alert('You set a percentage or an amount.');
                                return false;
                            }

                            // Percentage can't exceed 100%
                            if (v2Checkout.CartRemiseType == 'percentage' && NexoAPI.ParseFloat(value) > 100) {
                                value = 100;
                            } else if (v2Checkout.CartRemiseType == 'flat' && NexoAPI.ParseFloat(value) > v2Checkout.CartValue) {
                                // flat discount cannot exceed cart value
                                value = v2Checkout.CartValue;
                            }

                            $('[name="discount_value"]').focus();
                            $('[name="discount_value"]').blur();

                            v2Checkout.CartRemiseEnabled = true;
                            v2Checkout.calculateCartDiscount(value);
                            v2Checkout.refreshCartValues();
                        }
                    });

                    $('.percentage_discount').bind('click', function() {
                        if (!$(this).hasClass('active')) {
                            if ($('.flat_discount').hasClass('active')) {
                                $('.flat_discount').removeClass('active');
                            }

                            $(this).addClass('active');

                            // Proceed a quick check on the percentage value
                            $('[name="discount_value"]').focus();

                            v2Checkout.CartRemiseType = 'percentage';

                            $('.discount_type').html(': <span class=\"label label-primary\">percentage</span>');
                        }
                    });

                    $('.flat_discount').bind('click', function() {
                        if (!$(this).hasClass('active')) {
                            if ($('.percentage_discount').hasClass('active')) {
                                $('.percentage_discount').removeClass('active');
                            }

                            $(this).addClass('active');

                            $('[name="discount_value"]').focus();
                            $('[name="discount_value"]').blur();

                            v2Checkout.CartRemiseType = 'flat';

                            $('.discount_type').html(': <span class=\"label label-info\">fixed price</span>');
                        }
                    });

                    // Fillback form
                    if (v2Checkout.CartRemiseType != null) {
                        $('.' + v2Checkout.CartRemiseType + '_discount').trigger('click');

                        if (v2Checkout.CartRemiseType == 'percentage') {
                            $('[name="discount_value"]').val(v2Checkout.CartRemisePercent);
                        } else if (v2Checkout.CartRemiseType == 'flat') {
                            $('[name="discount_value"]').val(v2Checkout.CartRemise);
                        }

                    } else {
                        $('.flat_discount').trigger('click');
                    }

                    $('[name="discount_value"]').bind('blur', function() {

                        if (NexoAPI.ParseFloat($(this).val()) < 0) {
                            $(this).val(0);
                        }

                        // Percentage allowed to 100% only
                        if (v2Checkout.CartRemiseType == 'percentage' && NexoAPI.ParseFloat($('[name="discount_value"]').val()) > 100) {
                            $(this).val(100);
                        } else if (v2Checkout.CartRemiseType == 'flat' && NexoAPI.ParseFloat($('[name="discount_value"]').val()) > v2Checkout.CartValue) {
                            // flat discount cannot exceed cart value
                            $(this).val(v2Checkout.CartValue);
                            NexoAPI.Notify().info('Warning', 'The fixed discount cannot exceed the current value of the cart. The amount of the discount was reduced to the current value of the cart.');
                        }
                    });

                    for (var i = 0; i <= 9; i++) {
                        $('#discount-box-wrapper').find('.numpad' + i).bind('click', function() {
                            var current_value = $('[name="discount_value"]').val();
                            current_value = current_value == '0' ? '' : current_value;
                            $('[name="discount_value"]').val(current_value + $(this).val());
                        });
                    }

                    $('.numpadclear').bind('click', function() {
                        $('[name="discount_value"]').val(0);
                    });

                    $('.numpad00').bind('click', function() {
                        var current_value = $('[name="discount_value"]').val();
                        current_value = current_value == '0' ? '' : current_value;
                        $('[name="discount_value"]').val(current_value + '00');
                    });

                    $('.numpaddot').bind('click', function() {
                        var current_value = $('[name="discount_value"]').val();
                        current_value = current_value == '0' ? '' : current_value;
                        $('[name="discount_value"]').val(current_value + '...');
                    });

                    $('.numpaddel').bind('click', function() {
                        var numpad_value = $('[name="discount_value"]').val();
                        numpad_value = numpad_value.substr(0, numpad_value.length - 1);
                        numpad_value = numpad_value == '' ? 0 : numpad_value;
                        $('[name="discount_value"]').val(numpad_value);
                    });
                };

                /**
                 * Bind Quick Edit item
                 *
                 **/

                this.bindQuickEditItem = function() {
                    $('.quick_edit_item').bind('click', function() {

                        var CartItem = $(this).closest('[cart-item]');
                        var Barcode = $(CartItem).data('item-barcode');
                        var CurrentItem = false;

                        _.each(v2Checkout.CartItems, function(value, key) {
                            if (typeof value != 'undefined') {
                                if (value.CODEBAR == Barcode) {
                                    CurrentItem = value;
                                    return;
                                }
                            }
                        });

                        if (v2Checkout.CartShadowPriceEnabled == false) {
                            document.location = 'http://demo-nexopos.tendoo.org/dashboard/nexo/produits/lists/edit/' + CurrentItem.ID
                            return;
                        }

                        if (CurrentItem != false) {
                            var dom = '<h4 class="text-center">Edit item ' + CurrentItem.DESIGN + '</h4>' +
                                    '<div class="input-group">' +
                                    '<span class="input-group-addon" id="basic-addon1">Set a selling price</span>' +
                                    '<input type="text" class="current_item_price form-control" placeholder="Set a selling price" aria-describedby="basic-addon1">' +
                                    '<span class="input-group-addon">Threshold: <span class="sale_price"></span></span>' +
                                    '</div>';

                        } else {

                            NexoAPI.Bootbox().alert('Product not found');

                            var dom = '';
                        }

                        // http://demo-nexopos.tendoo.org/dashboard/nexo/produits/lists/edit			
                        NexoAPI.Bootbox().confirm(dom, function(action) {
                            if (action) {
                                if (NexoAPI.ParseFloat($('.current_item_price').val()) < NexoAPI.ParseFloat(CurrentItem.PRIX_DE_VENTE)) {
                                    NexoAPI.Bootbox().alert('The new price can not be lower than the minimum price (threshold)');
                                    return false;
                                } else {
                                    _.each(v2Checkout.CartItems, function(value, key) {
                                        if (typeof value != 'undefined') {
                                            if (value.CODEBAR == CurrentItem.CODEBAR) {
                                                value.SHADOW_PRICE = NexoAPI.ParseFloat($('.current_item_price').val());
                                                return;
                                            }
                                        }
                                    });
                                    // Refresh Cart
                                    v2Checkout.buildCartItemTable();
                                }
                            }
                        });

                        $('.sale_price').html(NexoAPI.DisplayMoney(CurrentItem.PRIX_DE_VENTE));
                        $('.current_item_price').val(CurrentItem.SHADOW_PRICE);

                    });
                };

                /**
                 * Build Cart Item table
                 * @return void
                 **/

                this.buildCartItemTable = function() {
                    // Empty Cart item table first
                    this.emptyCartItemTable();
                    this.CartValue = 0;
                    var _tempCartValue = 0;
                    this.CartTotalItems = 0;

                    if (_.toArray(this.CartItems).length > 0) {
                        _.each(this.CartItems, function(value, key) {

                            var promo_start = moment(value.SPECIAL_PRICE_START_DATE);
                            var promo_end = moment(value.SPECIAL_PRICE_END_DATE);

                            var MainPrice = NexoAPI.ParseFloat(value.PRIX_DE_VENTE)
                            var Discounted = '';
                            var CustomBackground = '';
                            value.PROMO_ENABLED = false;

                            if (promo_start.isBefore(v2Checkout.CartDateTime)) {
                                if (promo_end.isSameOrAfter(v2Checkout.CartDateTime)) {
                                    value.PROMO_ENABLED = true;
                                    MainPrice = NexoAPI.ParseFloat(value.PRIX_PROMOTIONEL);
                                    Discounted = '<small><del>' + NexoAPI.DisplayMoney(NexoAPI.ParseFloat(value.PRIX_DE_VENTE)) + '</del></small>';
                                    CustomBackground = 'background:#DFF0D8';
                                }
                            }

                            // @since 2.7.1
                            if (v2Checkout.CartShadowPriceEnabled) {
                                MainPrice = NexoAPI.ParseFloat(value.SHADOW_PRICE);
                            }

                            // <span class="btn btn-primary btn-xs item-reduce hidden-sm hidden-xs">-</span> <input type="number" style="width:40px;border-radius:5px;border:solid 1px #CCC;" maxlength="3"/> <span class="btn btn-primary btn-xs   hidden-sm hidden-xs">+</span>

                            // http://demo-nexopos.tendoo.org/dashboard/nexo/produits/lists/edit				// /' + value.ID + '

                            var cartTableBeforeItemName = NexoAPI.events.applyFilters('cart_before_item_name', '<a class="btn btn-sm btn-default quick_edit_item" href="javascript:void(0)" style="vertical-align:inherit;margin-right:10px;"><i class="fa fa-edit"></i></a>');

                            // :: alert( value.DESIGN.length );
                            var item_design = value.DESIGN.length > 20 ? '<span style="text-overflow:hidden">' + value.DESIGN.substr(0, 20) + '</span>' : value.DESIGN;

                            $('#cart-table-body').find('table').append(
                                    '<tr cart-item data-line-weight="' + (MainPrice * parseInt(value.QTE_ADDED)) + '" data-item-barcode="' + value.CODEBAR + '">' +
                                    '<td width="210" class="text-left" style="line-height:30px;">' + cartTableBeforeItemName + ' <span style="text-transform: uppercase;">' + item_design + '</span></td>' +
                                    '<td width="130" class="text-center"  style="line-height:30px;">' + NexoAPI.DisplayMoney(MainPrice) + ' ' + Discounted + '</td>' +
                                    '<td width="145" class="text-center">' +
                                    '<div class="input-group input-group-sm">' +
                                    '<span class="input-group-btn">' +
                                    '<button class="btn btn-default item-reduce">-</button>' +
                                    '</span>' +
                                    '<input type="number" name="shop_item_quantity" value="' + value.QTE_ADDED + '" class="form-control" aria-describedby="sizing-addon3">' +
                                    '<span class="input-group-btn">' +
                                    '<button class="btn btn-default item-add">+</button>' +
                                    '</span>' +
                                    '</div>' +
                                    '</td>' +
                                    '<td width="115" class="text-right" style="line-height:30px;">' + NexoAPI.DisplayMoney(MainPrice * parseInt(value.QTE_ADDED)) + '</td>' +
                                    '</tr>'
                                    );
                            _tempCartValue += (MainPrice * parseInt(value.QTE_ADDED));

                            // Just to count all products
                            v2Checkout.CartTotalItems += parseInt(value.QTE_ADDED);
                        });

                        this.CartValue = _tempCartValue;

                    } else {
                        $(this.CartTableBody).find('tbody').html('<tr id="cart-table-notice"><td colspan="4">Please add an item</td></tr>');
                    }

                    this.bindAddReduceActions();
                    this.bindQuickEditItem();
                    this.bindAddByInput();
                    this.refreshCartValues();

                    // @since 2.7.3
                    // trigger action when cart is refreshed
                    NexoAPI.events.doAction('cart_refreshed', v2Checkout);
                }

                /**
                 * Calculate Cart discount
                 **/

                this.calculateCartDiscount = function(value) {

                    if (value == '' || value == '0') {
                        this.CartRemiseEnabled = false;
                    }

                    // Display Notice
                    if ($('.cart-discount-notice-area').find('.cart-discount').length > 0) {
                        $('.cart-discount-notice-area').find('.cart-discount').remove();
                    }

                    if (this.CartRemiseEnabled == true) {

                        if (this.CartRemiseType == 'percentage') {
                            if (typeof value != 'undefined') {
                                this.CartRemisePercent = NexoAPI.ParseFloat(value);
                            }

                            // Only if the cart is not empty
                            if (this.CartValue > 0) {
                                this.CartRemise = (this.CartRemisePercent * this.CartValue) / 100;
                            } else {
                                this.CartRemise = 0;
                            }

                            if (this.CartRemiseEnabled) {
                                $('.cart-discount-notice-area').append('<span style="cursor: pointer;margin:0px 2px;" class="animated bounceIn btn expandable btn-primary btn-xs cart-discount"><i class="fa fa-remove"></i> Discount:' + this.CartRemisePercent + '%</span>');
                            }

                        } else if (this.CartRemiseType == 'flat') {
                            if (typeof value != 'undefined') {
                                this.CartRemise = NexoAPI.ParseFloat(value);
                            }

                            if (this.CartRemiseEnabled) {
                                $('.cart-discount-notice-area').append('<span style="cursor: pointer;margin:0px 2px;" class="animated bounceIn btn expandable btn-primary btn-xs cart-discount"><i class="fa fa-remove"></i> Discount:' + NexoAPI.DisplayMoney(this.CartRemise) + '</span>');
                            }
                        }

                    }

                    this.bindRemoveCartRemise();
                }

                /**
                 * Calculate cart ristourne
                 **/

                this.calculateCartRistourne = function() {

                    // Will be overwritten by enabled ristourne
                    this.CartRistourne = 0;

                    $('.cart-discount-notice-area').find('.cart-ristourne').remove();

                    if (this.CartRistourneEnabled) {

                        if (this.CartRistourneType == 'percent') {

                            if (this.CartRistournePercent != '') {
                                this.CartRistourne = (NexoAPI.ParseFloat(this.CartRistournePercent) * this.CartValue) / 100;
                            }

                            $('.cart-discount-notice-area').append('<span style="cursor: pointer; margin:0px 2px;" class="animated bounceIn btn expandable btn-info btn-xs cart-ristourne"><i class="fa fa-remove"></i> Refund :' + this.CartRistournePercent + '%</span>');

                        } else if (this.CartRistourneType == 'amount') {
                            if (this.CartRistourneAmount != '') {
                                this.CartRistourne = NexoAPI.ParseFloat(this.CartRistourneAmount);
                            }

                            $('.cart-discount-notice-area').append('<span style="cursor: pointer;margin:0px 2px;" class="animated bounceIn btn expandable btn-info btn-xs cart-ristourne"><i class="fa fa-remove"></i> Refund :' + NexoAPI.DisplayMoney(this.CartRistourneAmount) + '</span>');

                        }

                        this.bindRemoveCartRistourne();
                    }
                }

                /**
                 * Calculate Group Discount
                 **/

                this.calculateCartGroupDiscount = function() {

                    $('.cart-discount-notice-area').find('.cart-group-discount').remove();

                    if (this.CartGroupDiscountEnabled == true) {
                        if (this.CartGroupDiscountType == 'percent') {
                            if (this.CartGroupDiscountPercent != '') {
                                this.CartGroupDiscount = (NexoAPI.ParseFloat(this.CartGroupDiscountPercent) * this.CartValue) / 100;

                                $('.cart-discount-notice-area').append('<p style="cursor: pointer; margin:0px 2px;" class="animated bounceIn btn btn-warning expandable btn-xs cart-group-discount"><i class="fa fa-remove"></i> Group discount :' + this.CartGroupDiscountPercent + '%</p>');
                            }
                        } else if (this.CartGroupDiscountType == 'amount') {
                            if (this.CartGroupDiscountAmount != '') {
                                this.CartGroupDiscount = NexoAPI.ParseFloat(this.CartGroupDiscountAmount);

                                $('.cart-discount-notice-area').append('<p style="cursor: pointer; margin:0px 2px;" class="animated bounceIn btn btn-warning expandable btn-xs cart-group-discount"><i class="fa fa-remove"></i> Group discount :' + NexoAPI.DisplayMoney(this.CartGroupDiscountAmount) + '</p>');
                            }
                        }

                        this.bindRemoveCartGroupDiscount();
                    }
                };

                /**
                 * Calculate Cart VAT
                 **/

                this.calculateCartVAT = function() {
                    if (this.CartVATEnabled == true) {
                        this.CartVAT = NexoAPI.ParseFloat((this.CartVATPercent * this.CartValueRRR) / 100);
                    }
                };

                /**
                 * Cancel an order and return to order list
                 **/

                this.cartCancel = function() {
                    NexoAPI.Bootbox().confirm('Would you like to cancel this order?', function(action) {
                        if (action == true) {
                            v2Checkout.resetCart();
                            // document.location	=	'http://demo-nexopos.tendoo.org/dashboard/nexo/commandes/lists';
                        }
                    });
                }

                /**
                 * Cart Group Reset
                 **/

                this.cartGroupDiscountReset = function() {
                    this.CartGroupDiscount = 0; // final amount
                    this.CartGroupDiscountAmount = 0; // Amount set on each group
                    this.CartGroupDiscountPercent = 0; // percent set on each group
                    this.CartGroupDiscountType = null; // Discount type
                    this.CartGroupDiscountEnabled = false;

                    $('.cart-discount-notice-area').find('.cart-group-discount').remove();
                }


                /**
                 * Submit order
                 * @params payment mean
                 **/

                this.cartSubmitOrder = function(payment_means) {
                    var order_items = new Array;

                    _.each(this.CartItems, function(value, key) {

                        var ArrayToPush = [
                            value.ID,
                            value.QTE_ADDED,
                            value.CODEBAR,
                            value.PROMO_ENABLED ? value.PRIX_PROMOTIONEL : (v2Checkout.CartShadowPriceEnabled ? value.SHADOW_PRICE : value.PRIX_DE_VENTE),
                            value.QUANTITE_VENDU,
                            value.QUANTITE_RESTANTE,
                            // @since 2.8.2
                            value.STOCK_ENABLED,
                        ];

                        // improved @since 2.7.3
                        // add meta by default
                        var ItemMeta = NexoAPI.events.applyFilters('items_metas', []);

                        var MetaKeys = new Array;

                        _.each(ItemMeta, function(_value, key) {
                            var unZiped = _.keys(_value);
                            MetaKeys.push(unZiped[0]);
                        });

                        var AllMetas = new Object;

                        // console.log( value );

                        _.each(MetaKeys, function(MetaKey) {
                            AllMetas = _.extend(AllMetas, _.object([MetaKey], [_.propertyOf(value)(MetaKey)]));
                        });

                        // console.log( AllMetas );

                        // 
                        ArrayToPush.push(JSON.stringify(AllMetas));

                        // Add Meta JSON stringified to order_item
                        order_items.push(ArrayToPush);
                    });

                    var order_details = new Object;
                    order_details.TOTAL = NexoAPI.ParseFloat(this.CartToPay);
                    order_details.REMISE = NexoAPI.ParseFloat(this.CartRemise);
                    order_details.RABAIS = NexoAPI.ParseFloat(this.CartRabais);
                    order_details.RISTOURNE = NexoAPI.ParseFloat(this.CartRistourne);
                    order_details.TVA = NexoAPI.ParseFloat(this.CartVAT);
                    order_details.REF_CLIENT = this.CartCustomerID == null ? this.customers.DefaultCustomerID : this.CartCustomerID;
                    order_details.PAYMENT_TYPE = this.CartPaymentType;
                    order_details.GROUP_DISCOUNT = NexoAPI.ParseFloat(this.CartGroupDiscount);
                    order_details.DATE_CREATION = this.CartDateTime.format('YYYY-MM-DD HH:mm:ss')
                    order_details.ITEMS = order_items;
                    order_details.DEFAULT_CUSTOMER = this.DefaultCustomerID;
                    order_details.DISCOUNT_TYPE = 'percent';
                    order_details.HMB_DISCOUNT = '';
                    // @since 2.7.5
                    order_details.REGISTER_ID = 'default';

                    // @since 2.7.1, send editable order to Rest Server
                    order_details.EDITABLE_ORDERS = ["nexo_order_devis"];

                    // @since 2.7.3 add Order note
                    order_details.DESCRIPTION = this.CartNote;

                    // @since 2.8.2 add order meta
                    this.CartMetas = NexoAPI.events.applyFilters('order_metas', this.CartMetas);
                    order_details.METAS = JSON.stringify(this.CartMetas);

                    if (payment_means == 'cash') {

                        order_details.SOMME_PERCU = NexoAPI.ParseFloat(this.CartPerceivedSum);
                        order_details.SOMME_PERCU = isNaN(order_details.SOMME_PERCU) ? 0 : order_details.SOMME_PERCU;

                    } else if (payment_means == 'cheque' || payment_means == 'bank') {

                        order_details.SOMME_PERCU = NexoAPI.ParseFloat(this.CartToPay);

                    } else if (payment_means == 'stripe') {
                        if (this.CartAllowStripeSubmitOrder == true) {

                            order_details.SOMME_PERCU = NexoAPI.ParseFloat(this.CartToPay);

                        } else {
                            NexoAPI.Notify().info('Warning', 'The credit card must be charged before validating the order.');
                            return false;
                        }
                    } else {
                        // Handle for custom Payment Means
                        if (NexoAPI.events.applyFilters('check_payment_mean', [false, payment_means])[0] == true) {

                            /**
                             * Make sure to return order_details
                             **/

                            order_details = NexoAPI.events.applyFilters('payment_mean_checked', [order_details, payment_means])[0];

                        } else {

                            NexoAPI.Bootbox().alert('Unable to recognize the payment means.');
                            return false;

                        }
                    }

                    var ProcessURL = "http://demo-nexopos.tendoo.org/rest/nexo/order/4?store_id=4";
                    var ProcessType = 'POST';


                    // Filter Submited Details
                    order_details = NexoAPI.events.applyFilters('before_submit_order', order_details);

                    $.ajax(ProcessURL, {
                        dataType: 'json',
                        type: ProcessType,
                        data: order_details,
                        beforeSend: function() {
                            v2Checkout.paymentWindow.showSplash();
                            NexoAPI.Notify().info('Please wait', 'Payment in process...');
                        },
                        success: function(returned) {
                            v2Checkout.paymentWindow.hideSplash();
                            v2Checkout.paymentWindow.close();

                            if (_.isObject(returned)) {
                                // Init Message Object
                                var MessageObject = new Object;

                                var data = NexoAPI.events.applyFilters('test_order_type', [(returned.order_type == 'nexo_order_comptant'), returned]);
                                var test_order = data[0];

                                if (test_order == true) {


                                    if (NexoAPI.events.applyFilters('cart_enable_print', true)) {

                                        MessageObject.title = 'Done';
                                        MessageObject.msg = 'The order is being printed.';
                                        MessageObject.type = 'success';

                                        $('body').append('<iframe style="display:none;" id="CurrentReceipt" name="CurrentReceipt" src="http://demo-nexopos.tendoo.org/dashboard/stores/4/nexo/print/order_receipt/' + returned.order_id + '?refresh=true"></iframe>');

                                        window.frames["CurrentReceipt"].focus();
                                        window.frames["CurrentReceipt"].print();

                                        setTimeout(function() {
                                            $('#CurrentReceipt').remove();
                                        }, 5000);

                                    }
                                    // Remove filter after it's done
                                    NexoAPI.events.removeFilter('cart_enable_print');


                                    /**
                                     * Send SMS
                                     **/
                                    // Do Action when order is complete and submited
                                    NexoAPI.events.doAction('is_cash_order', [v2Checkout, returned]);
                                } else {
                                    MessageObject.title = 'Done';
                                    MessageObject.msg = 'The order has been registered, but cannot be printed as long as it is not complete.';
                                    MessageObject.type = 'info';

                                }

                                // Filter Message Callback
                                var data = NexoAPI.events.applyFilters('callback_message', [MessageObject, returned]);
                                MessageObject = data[0];

                                // For Success
                                if (MessageObject.type == 'success') {

                                    NexoAPI.Notify().success(MessageObject.title, MessageObject.msg);

                                    // For Info
                                } else if (MessageObject.type == 'info') {

                                    NexoAPI.Notify().info(MessageObject.title, MessageObject.msg);

                                }
                            }

                            v2Checkout.resetCart();
                        },
                        error: function() {
                            v2Checkout.paymentWindow.hideSplash();
                            NexoAPI.Notify().warning('An error has occurred.', 'The payment could not be made.');
                        }
                    });
                };

                /**
                 * Check Checkout Balance
                 * @pending
                 * @deprecated
                 **/

                this.checkoutBalance = new function() {
                    return false;
                    this.open = function() {
                        // Show Loading Splash

                        NexoAPI.Bootbox().prompt('Please set outlet initial balance', function(action) {
                            if (action == null) {
                                NexoAPI.Bootbox().alert('Before continuing, you must set an amount.', function() {
                                    v2Checkout.checkoutBalance.open();
                                });

                                // Special Bootbox treatment
                                $('.bootbox.modal').css('z-index', 5000);
                            } else {

                                if (NexoAPI.ParseFloat(action) < 0 || isNaN(action) || action == '') {
                                    NexoAPI.Bootbox().alert('The specified amount is incorrect. Please specify a value greater or equal to \"0\".', function() {
                                        v2Checkout.checkoutBalance.open();
                                    });

                                    // Special Bootbox treatment
                                    $('.bootbox.modal').css('z-index', 5000);
                                } else {
                                    // Send amount online
                                    $.ajax('http://demo-nexopos.tendoo.org/rest/nexo/pos_balance?store_id=4', {
                                        type: 'POST',
                                        data: _.object(['amount', 'type', 'author', 'date'], [action, 'opening_balance', 4, v2Checkout.CartDateTime.format('YYYY-MM-DD HH:mm:ss')]),
                                        success: function(json) {
                                            console.log(json);
                                        }
                                    });
                                }
                            }
                        });

                        // Special Bootbox treatment
                        $('.bootbox.modal').css('z-index', 5000);
                    }
                }

                /**
                 * Customer DropDown Menu
                 **/

                this.customers = new function() {

                    this.DefaultCustomerID = '1';

                    /**
                     * Bind
                     **/

                    this.bind = function() {
                        $('.dropdown-bootstrap').selectpicker({
                            style: 'btn-default',
                            size: 4
                        });

                        if (typeof $('.cart-add-customer').attr('bound') == 'undefined') {
                            $('.cart-add-customer').bind('click', function() {
                                v2Checkout.customers.createBox();
                            })
                            $('.cart-add-customer').attr('bound', 'true');
                        }

                        if (typeof $('.customers-list').attr('change-bound') == 'undefined') {
                            $('.customers-list').bind('change', function() {
                                v2Checkout.customers.bindSelectCustomer($(this).val());
                            });
                            $('.customers-list').attr('change-bound', 'true');
                        }
                    }

                    /**
                     * Create Box
                     **/

                    this.createBox = function() {
                        var userForm =
                                '<form id="NewClientForm" method="POST">' +
                                '<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button><i style="font-size:18px;margin-right:5px;" class="fa fa-warning"></i> All other information like \"date of birth\" may be filled later.</div>' +
                                '<div class="form-group">' +
                                '<div class="input-group">' +
                                '<span class="input-group-addon" id="basic-addon1">Client name</span>' +
                                '<input type="text" class="form-control" placeholder="Name" name="customer_name" aria-describedby="basic-addon1">' +
                                '</div>' +
                                '</div>' +
                                '<div class="form-group">' +
                                '<div class="input-group">' +
                                '<span class="input-group-addon" id="basic-addon1">Customer First Name</span>' +
                                '<input type="text" class="form-control" placeholder="First Name" name="customer_surname" aria-describedby="basic-addon1">' +
                                '</div>' +
                                '</div>' +
                                '<div class="form-group">' +
                                '<div class="input-group">' +
                                '<span class="input-group-addon" id="basic-addon1">Customer Email:</span>' +
                                '<input type="text" class="form-control" placeholder="Email" name="customer_email" aria-describedby="basic-addon1">' +
                                '</div>' +
                                '</div>' +
                                '<div class="form-group">' +
                                '<div class="input-group">' +
                                '<span class="input-group-addon" id="basic-addon1">Customer Phone</span>' +
                                '<input type="text" class="form-control" placeholder="Phone:" name="customer_tel" aria-describedby="basic-addon1">' +
                                '</div>' +
                                '</div>' +
                                '<div class="form-group">' +
                                '<div class="input-group">' +
                                '<span class="input-group-addon" id="basic-addon1">Customer Group</span>' +
                                '<select type="text" class="form-control customers_groups" name="customer_group" aria-describedby="basic-addon1">' +
                                '<option value="">Please choose a customer</option>' +
                                '</select>' +
                                '</div>' +
                                '</div>' +
                                '</form>';

                        NexoAPI.Bootbox().confirm(userForm, function(action) {
                            if (action) {
                                return v2Checkout.customers.create(
                                        $('[name="customer_name"]').val(),
                                        $('[name="customer_surname"]').val(),
                                        $('[name="customer_email"]').val(),
                                        $('[name="customer_tel"]').val(),
                                        $('[name="customer_group"]').val()
                                        );
                            }
                        });

                        _.each(v2Checkout.CustomersGroups, function(value, key) {
                            $('.customers_groups').append('<option value="' + value.ID + '">' + value.NAME + '</option>');
                        });
                    };

                    /**
                     * Create Customer
                     *
                     * @params string user name
                     * @params string user surname
                     * @params string user email
                     * @params string user phone
                     * @params int user group
                     * @return bool
                     **/

                    this.create = function(name, surname, email, phone, ref_group) {
                        // Name is required
                        if (name == '') {
                            NexoAPI.Bootbox().alert('You must provide a name for le new customer');
                            return false;
                        }
                        // Group is required
                        if (ref_group == '') {
                            NexoAPI.Bootbox().alert('You must assign the customer to a group');
                            return false;
                        }
                        // Ajax
                        $.ajax('http://demo-nexopos.tendoo.org/rest/nexo/customer?store_id=4', {
                            dataType: 'json',
                            type: 'POST',
                            data: _.object(
                                    // if Store Feature is enabled
                                            ['nom', 'prenom', 'email', 'tel', 'ref_group', 'author', 'date_creation'],
                                            [name, surname, email, phone, ref_group, 4, v2Checkout.CartDateTime.format('YYYY-MM-DD HH:mm:ss')]
                                            ),
                                    success: function() {
                                        v2Checkout.customers.get();
                                    }
                                });
                            }


                            /**
                             * Bind select customer
                             * Check if a specific customer due to his purchages or group
                             * should have a discount
                             **/

                            this.bindSelectCustomer = function(customer_id) {
                                // Reset Ristourne if enabled
                                v2Checkout.CartRistourneEnabled = false;

                                if (customer_id != this.DefaultCustomerID) {
                                    // DISCOUNT_ACTIVE
                                    $.ajax('http://demo-nexopos.tendoo.org/rest/nexo/customer/' + customer_id + '?store_id=4', {
                                        error: function() {
                                            v2Checkout.showError('ajax_fetch');
                                        },
                                        dataType: 'json',
                                        success: function(data) {
                                            if (data.length > 0) {
                                                v2Checkout.CartCustomerID = data[0].ID;
                                                v2Checkout.customers.check_discounts(data);
                                                v2Checkout.customers.check_groups_discounts(data);
                                                // Exect action on selecting customer
                                                NexoAPI.events.doAction('select_customer', data);
                                            }
                                        }
                                    });
                                } else {
                                    // Refresh Cart Value;
                                    v2Checkout.refreshCartValues();
                                }
                            };

                            /**
                             * Check discount for the customer
                             * @params object customer data
                             * @return void
                             **/

                            this.check_discounts = function(object) {
                                if (typeof object == 'object') {
                                    _.each(object, function(value, key) {
                                        // Restore orginal customer discount
                                        if (NexoAPI.ParseFloat(v2Checkout.CartRistourneCustomerID) == NexoAPI.ParseFloat(value.ID)) {
                                            v2Checkout.restoreCustomRistourne();
                                            v2Checkout.buildCartItemTable();
                                            v2Checkout.refreshCart();
                                        } else {
                                            if (value.DISCOUNT_ACTIVE == '1') {
                                                v2Checkout.restoreDefaultRistourne();
                                                v2Checkout.CartRistourneEnabled = true;
                                            }
                                        }
                                    });

                                    // Refresh Cart value;
                                    v2Checkout.refreshCartValues();
                                }
                            };

                            /**
                             * Check discount for user group
                             * @params object customer data
                             * @return void
                             **/

                            this.check_groups_discounts = function(object) {

                                // Reset Groups Discounts
                                v2Checkout.cartGroupDiscountReset();

                                if (typeof object == 'object') {

                                    _.each(object, function(Customer, key) {
                                        // Default customer can't benefit from group discount
                                        if (Customer.ID != v2Checkout.customers.DefaultCustomerID) {
                                            // Looping each groups to check whether this customer belong to one existing group
                                            _.each(v2Checkout.CustomersGroups, function(Group, Key) {
                                                if (Customer.REF_GROUP == Group.ID) {
                                                    // if group discount is enabled
                                                    if (Group.DISCOUNT_ENABLE_SCHEDULE == 'true') {
                                                        if (
                                                                moment(Group.DISCOUNT_START).isSameOrBefore(v2Checkout.CartDateTime) == false ||
                                                                moment(Group.DISCOUNT_END).endOf('day').isSameOrAfter(v2Checkout.CartDateTime) == false
                                                                ) {
                                                            /**
                                                             * Time Range is incorrect to enable Group discount
                                                             **/

                                                            console.log('time is incorrect for group discount');

                                                            return;
                                                        }
                                                    }

                                                    // If current customer belong to this group, let see if this group has active discount
                                                    if (Group.DISCOUNT_TYPE == 'percent') {
                                                        v2Checkout.CartGroupDiscountType = Group.DISCOUNT_TYPE;
                                                        v2Checkout.CartGroupDiscountPercent = Group.DISCOUNT_PERCENT;
                                                        v2Checkout.CartGroupDiscountEnabled = true;
                                                    } else if (Group.DISCOUNT_TYPE == 'amount') {
                                                        v2Checkout.CartGroupDiscountType = Group.DISCOUNT_TYPE;
                                                        v2Checkout.CartGroupDiscountAmount = Group.DISCOUNT_AMOUNT;
                                                        v2Checkout.CartGroupDiscountEnabled = true;
                                                    }
                                                }
                                            });
                                        }
                                    });

                                    // Refresh Cart value;
                                    v2Checkout.refreshCartValues();
                                }
                            };

                            /**
                             * Get Customers
                             **/

                            this.get = function() {
                                $.ajax('http://demo-nexopos.tendoo.org/rest/nexo/customer?store_id=4', {
                                    dataType: 'json',
                                    success: function(customers) {

                                        $('.customers-list').selectpicker('destroy');
                                        // Empty list first
                                        $('.customers-list').children().each(function(index, element) {
                                            $(this).remove();
                                        });
                                        ;

                                        _.each(customers, function(value, key) {
                                            if (parseInt(v2Checkout.CartCustomerID) == parseInt(value.ID)) {

                                                $('.customers-list').append('<option value="' + value.ID + '" selected="selected">' + value.NOM + '</option>');
                                                // Fix customer Selection
                                                NexoAPI.events.doAction('select_customer', [value]);

                                            } else {
                                                $('.customers-list').append('<option value="' + value.ID + '">' + value.NOM + '</option>');
                                            }
                                        });

                                        $('.customers-list').selectpicker('refresh');
                                    },
                                    error: function() {
                                        NexoAPI.Bootbox().alert('An error occurred during the data recovery');
                                    }
                                });
                            }

                            /**
                             * Get Customers Groups
                             **/

                            this.getGroups = function() {
                                $.ajax('http://demo-nexopos.tendoo.org/rest/nexo/customers_groups?store_id=4', {
                                    dataType: 'json',
                                    success: function(customers) {

                                        v2Checkout.CustomersGroups = customers;

                                    },
                                    error: function() {
                                        NexoAPI.Bootbox().alert('An error occurred during recovery of the client groups data');
                                    }
                                });
                            }

                            /**
                             * Start
                             **/

                            this.run = function() {
                                this.bind();
                                this.get();
                                this.getGroups();
                            };
                        }

                        /**
                         * Display Items on the grid
                         * @params Array
                         * @return void
                         **/

                        this.displayItems = function(json) {
                            if (json.length > 0) {
                                // Empty List
                                $('#filter-list').html('');

                                _.each(json, function(value, key) {

                                    /**
                                     * We test item quantity of skip that test if item is not countable.
                                     * value.TYPE = 0 means item is physical, = 1 means item is numerical
                                     * value.STATUS = 0 means item is on sale, = 1 means item is disabled
                                     **/

                                    if (((parseInt(value.QUANTITE_RESTANTE) > 0 && value.TYPE == '1') || (value.TYPE == '2')) && value.STATUS == '1') {

                                        var promo_start = moment(value.SPECIAL_PRICE_START_DATE);
                                        var promo_end = moment(value.SPECIAL_PRICE_END_DATE);

                                        var MainPrice = NexoAPI.ParseFloat(value.PRIX_DE_VENTE)
                                        var Discounted = '';
                                        var CustomBackground = '';
                                        var ImagePath = value.APERCU == '' ? '../modules/nexo/images/default.png' : value.APERCU;

                                        if (promo_start.isBefore(v2Checkout.CartDateTime)) {
                                            if (promo_end.isSameOrAfter(v2Checkout.CartDateTime)) {
                                                MainPrice = NexoAPI.ParseFloat(value.PRIX_PROMOTIONEL);
                                                Discounted = '<small style="color:#999;"><del>' + NexoAPI.DisplayMoney(NexoAPI.ParseFloat(value.PRIX_DE_VENTE)) + '</del></small>';
                                                // CustomBackground	=	'background:#DFF0D8';
                                            }
                                        }

                                        // @since 2.7.1
                                        if (v2Checkout.CartShadowPriceEnabled) {
                                            MainPrice = NexoAPI.ParseFloat(value.SHADOW_PRICE);
                                        }

                                        // style="max-height:100px;"
                                        // alert( value.DESIGN.length );
                                        var design = value.DESIGN.length > 15 ? '<span class="marquee_me">' + value.DESIGN + '</span>' : value.DESIGN;

                                        $('#filter-list').append(
                                                '<div class="col-lg-2 col-md-3 col-xs-6 shop-items filter-add-product noselect text-center" data-codebar="' + value.CODEBAR + '" style="' + CustomBackground + ';padding:5px; border-right: solid 1px #DEDEDE;border-bottom: solid 1px #DEDEDE;" data-design="' + value.DESIGN.toLowerCase() + '" data-category="' + value.REF_CATEGORIE + '" data-sku="' + value.SKU.toLowerCase() + '">' +
                                                '<img data-original="http://demo-nexopos.tendoo.org/public/upload/store_4/' + ImagePath + '" width="100" style="max-height:64px;" class="img-responsive img-rounded lazy">' +
                                                '<div class="caption text-center" style="padding:2px;overflow:hidden;"><strong class="item-grid-title">' + design + '</strong><br>' +
                                                '<span class="align-center">' + NexoAPI.DisplayMoney(MainPrice) + '</span>' + Discounted +
                                                '</div>' +
                                                '</div>');

                                        v2Checkout.ItemsCategories = _.extend(v2Checkout.ItemsCategories, _.object([value.REF_CATEGORIE], [value.NOM]));
                                    }
                                });

                                $('.filter-add-product').each(function() {
                                    $(this).bind('mouseenter', function() {
                                        $(this).find('.marquee_me').replaceWith('<marquee class="marquee_me" behavior="alternate" scrollamount="4" direction="left" style="width:100%;float:left;">' + $(this).find('.marquee_me').html() + '</marquee>');
                                    })
                                });

                                $('.filter-add-product').bind('mouseover', function() {
                                    $(this).bind('mouseleave', function() {
                                        $(this).find('.marquee_me').replaceWith('<span class="marquee_me">' + $(this).find('.marquee_me').html() + '</span>');
                                    })
                                });

                                // Bind Categorie @since 2.7.1
                                v2Checkout.bindCategoryActions();

                                // Add Lazy @since 2.6.1
                                $("img.lazy").lazyload({
                                    failure_limit: 10,
                                    load: function(e) {
                                        $(this).removeAttr('width');
                                    },
                                    container: $('.item-list-container')
                                });

                                // Bind Add to Items
                                this.bindAddToItems();
                            } else {
                                NexoAPI.Bootbox().alert('You cannot proceed with a sale, because no item is available for sale.');
                            }
                        };

                        /**
                         * Empty cart item table
                         *
                         **/

                        this.emptyCartItemTable = function() {
                            $('#cart-table-body').find('[cart-item]').remove();
                        };

                        /**
                         * Fetch Items
                         * Check whether an item is available and add it to the cart items table
                         * @return void
                         **/

                        this.fetchItem = function(codebar, qte_to_add, allow_increase, filter) {

                            var allow_increase = typeof allow_increase == 'undefined' ? true : allow_increase
                            var qte_to_add = typeof qte_to_add == 'undefined' ? 1 : qte_to_add;
                            var filter = typeof filter == 'undefined' ? 'CODEBAR' : filter;
                            // For Store Feature
                            var store_id = '4';


                            $.ajax('http://demo-nexopos.tendoo.org/rest/nexo/item/' + codebar + '/' + filter + '?store_id=' + store_id, {
                                success: function(_item) {

                                    /**
                                     * If Item is "On Sale"
                                     **/

                                    if (_item.length > 0 && _item[0].STATUS == '1') {
                                        var InCart = false;
                                        var InCartIndex = null;
                                        // Let's check whether an item is already added to cart
                                        _.each(v2Checkout.CartItems, function(value, _index) {
                                            if (value.CODEBAR == _item[0].CODEBAR) {
                                                InCartIndex = _index;
                                                InCart = true;
                                            }
                                        });

                                        if (InCart) {
                                            // if increase is disabled, we set value
                                            var comparison_qte = allow_increase == true ? parseInt(v2Checkout.CartItems[ InCartIndex ].QTE_ADDED) + parseInt(qte_to_add) : qte_to_add;

                                            /**
                                             * For "Out of Stock" notice to work, item must be physical
                                             * and Stock management must be enabled
                                             **/

                                            if (
                                                    parseInt(_item[0].QUANTITE_RESTANTE) - (comparison_qte) < 0
                                                    && _item[0].TYPE == '1'
                                                    && _item[0].STOCK_ENABLED == '1'
                                                    ) {
                                                NexoAPI.Notify().error(
                                                        'Out of Stock',
                                                        'Cannot add this product. The remaining quantity of the product is not sufficient.'
                                                        );
                                            } else {
                                                if (allow_increase) {
                                                    // Fix concatenation when order was edited
                                                    v2Checkout.CartItems[ InCartIndex ].QTE_ADDED = parseInt(v2Checkout.CartItems[ InCartIndex ].QTE_ADDED);
                                                    v2Checkout.CartItems[ InCartIndex ].QTE_ADDED += parseInt(qte_to_add);
                                                } else {
                                                    if (qte_to_add > 0) {
                                                        v2Checkout.CartItems[ InCartIndex ].QTE_ADDED = parseInt(qte_to_add);
                                                    } else {
                                                        NexoAPI.Bootbox().confirm('Defininr \"0\" as the quantity, remove the product from the cart. Do you want to continue?', function(response) {
                                                            // Delete item from cart when confirmed
                                                            if (response) {
                                                                v2Checkout.CartItems.splice(InCartIndex, 1);
                                                                v2Checkout.buildCartItemTable();
                                                            }

                                                        });
                                                    }
                                                }
                                            }
                                        } else {
                                            if (parseInt(_item[0].QUANTITE_RESTANTE) - qte_to_add < 0) {
                                                NexoAPI.Notify().error(
                                                        'Out of Stock',
                                                        'Cannot add to the cart since it\'s out of Stock!'
                                                        );
                                            } else {
                                                // improved @since 2.7.3
                                                // add meta by default
                                                var ItemMeta = NexoAPI.events.applyFilters('items_metas', []);

                                                var FinalMeta = [['QTE_ADDED'], [qte_to_add]];

                                                _.each(ItemMeta, function(value, key) {
                                                    FinalMeta[0].push(_.keys(value)[0]);
                                                    FinalMeta[1].push(_.values(value)[0]);
                                                });

                                                v2Checkout.CartItems.unshift(_.extend(_item[0], _.object(FinalMeta[0], FinalMeta[1])));
                                            }
                                        }

                                        // Build Cart Table Items
                                        v2Checkout.refreshCart();
                                        v2Checkout.buildCartItemTable();

                                    } else {
                                        NexoAPI.Notify().error('Cannot add the item to shopping cart', 'Unable to retrieve the article, it is not found, the code sent unavailable or incorrect.');
                                    }
                                },
                                dataType: 'json',
                                error: function() {
                                    NexoAPI.Notify().error('An error has occurred.', 'Unable to retrieve the data. The item you are looking is not found.');
                                }

                            });
                        };

                        /**
                         * Filter Item
                         *
                         * @params string
                         * @return void
                         **/

                        this.filterItems = function(content) {
                            content = _.toArray(content);
                            if (content.length > 0) {
                                $('#product-list-wrapper').find('[data-category]').hide();
                                _.each(content, function(value, key) {
                                    $('#product-list-wrapper').find('[data-category="' + value + '"]').show();
                                });
                            } else {
                                $('#product-list-wrapper').find('[data-category]').show();
                            }
                        }

                        /**
                         * Get Items
                         **/

                        this.getItems = function(beforeCallback, afterCallback) {
                            $.ajax('http://demo-nexopos.tendoo.org/rest/nexo/item?store_id=4', {
                                beforeSend: function() {
                                    if (typeof beforeCallback == 'function') {
                                        beforeCallback();
                                    }
                                },
                                error: function() {
                                    NexoAPI.Bootbox().alert('An error occurred during the data recovery');
                                },
                                success: function(content) {
                                    $(this.ItemsListSplash).hide();
                                    $(this.ProductListWrapper).find('.box-body').css({'visibility': 'visible'});

                                    v2Checkout.displayItems(content);

                                    if (typeof afterCallback == 'function') {
                                        afterCallback();
                                    }
                                },
                                dataType: "json"
                            });
                        };

                        /**
                         * Init Cart Date
                         *
                         **/

                        this.initCartDateTime = function() {
                            this.CartDateTime = moment('2016-09-06T04:53:16-04:00');
                            $('.content-header h1').append('<small class="pull-right" id="cart-date" style="display:none;line-height: 30px;"></small>');

                            setInterval(function() {
                                v2Checkout.CartDateTime.add(1, 's');
                                // YYYY-MM-DD
                                $('#cart-date').html(v2Checkout.CartDateTime.format('HH:mm:ss'));
                            }, 1000);

                            setTimeout(function() {
                                $('#cart-date').show(500);
                            }, 1000);
                        };

                        /**
                         * Is Cart empty
                         * @return boolean
                         **/

                        this.isCartEmpty = function() {
                            if (_.toArray(this.CartItems).length > 0) {
                                return false;
                            }
                            return true;
                        }

                        /**
                         * Display item Settings
                         * this option let you select categories to displays
                         **/

                        this.itemsSettings = function() {
                            this.buildItemsCategories('.categories_dom_wrapper');
                        };

                        /**
                         * Show Numpad
                         **/

                        this.showNumPad = function(object, text, object_wrapper, real_time) {
                            // Field
                            var field = real_time == true ? object : '[name="numpad_field"]';

                            // If real time editing is enabled
                            var input_field = !real_time ?
                                    '<div class="form-group">' +
                                    '<input type="text" class="form-control input-lg" name="numpad_field"/>' +
                                    '</div>' : '';

                            var NumPad =
                                    '<form id="numpad">' +
                                    '<h4 class="text-center">' + (text ? text : '') + '</h4><br>' +
                                    input_field +
                                    '<div class="row">' +
                                    '<div class="col-lg-3 col-md-3 col-xs-3">' +
                                    '<input type="button" class="btn btn-default btn-block btn-lg numpad numpad7" value="7"/>' +
                                    '</div>' +
                                    '<div class="col-lg-3 col-md-3 col-xs-3">' +
                                    '<input type="button" class="btn btn-default btn-block btn-lg numpad numpad8" value="8"/>' +
                                    '</div>' +
                                    '<div class="col-lg-3 col-md-3 col-xs-3">' +
                                    '<input type="button" class="btn btn-default btn-block btn-lg numpad numpad9" value="9"/>' +
                                    '</div>' +
                                    '<div class="col-lg-3 col-md-3 col-xs-3">' +
                                    '<input type="button" class="btn btn-default btn-block btn-lg numpad numpadplus" value="+"/>' +
                                    '</div>' +
                                    '</div>' +
                                    '<br>' +
                                    '<div class="row">' +
                                    '<div class="col-lg-3 col-md-3 col-xs-3">' +
                                    '<input type="button" class="btn btn-default btn-block btn-lg numpad numpad4" value="4"/>' +
                                    '</div>' +
                                    '<div class="col-lg-3 col-md-3 col-xs-3">' +
                                    '<input type="button" class="btn btn-default btn-block btn-lg numpad numpad5" value="5"/>' +
                                    '</div>' +
                                    '<div class="col-lg-3 col-md-3 col-xs-3">' +
                                    '<input type="button" class="btn btn-default btn-block btn-lg numpad numpad6" value="6"/>' +
                                    '</div>' +
                                    '<div class="col-lg-3 col-md-3 col-xs-3">' +
                                    '<input type="button" class="btn btn-default btn-block btn-lg numpad numpadminus" value="-"/>' +
                                    '</div>' +
                                    '</div>' +
                                    '<br>' +
                                    '<div class="row">' +
                                    '<div class="col-lg-3 col-md-3 col-xs-3">' +
                                    '<input type="button" class="btn btn-default btn-block btn-lg numpad numpad1" value="1"/>' +
                                    '</div>' +
                                    '<div class="col-lg-3 col-md-3 col-xs-3">' +
                                    '<input type="button" class="btn btn-default btn-block btn-lg numpad numpad2" value="2"/>' +
                                    '</div>' +
                                    '<div class="col-lg-3 col-md-3 col-xs-3">' +
                                    '<input type="button" class="btn btn-default btn-block btn-lg numpad numpad3" value="3"/>' +
                                    '</div>' +
                                    '<div class="col-lg-3 col-md-3 col-xs-3">' +
                                    '<input type="button" class="btn btn-warning btn-block btn-lg numpad numpaddel" value="&larr;"/>' +
                                    '</div>' +
                                    '</div>' +
                                    '<br/>' +
                                    '<div class="row">' +
                                    '<div class="col-lg-6 col-md-6 col-xs-6">' +
                                    '<input type="button" class="btn btn-default btn-block btn-lg numpad numpad0" value="0"/>' +
                                    '</div>' +
                                    '<div class="col-lg-3 col-md-3 col-xs-3">' +
                                    '<input type="button" class="btn btn-default btn-block btn-lg numpad numpaddot" value="."/>' +
                                    '</div>' +
                                    '<div class="col-lg-3 col-md-3 col-xs-3">' +
                                    '<button type="button" class="btn btn-danger btn-block btn-lg numpad numpadclear"><i class="fa fa-eraser"></i></button></div>' +
                                    '</div>' +
                                    '</div>'
                            '</form>';

                            if ($(object_wrapper).length > 0) {
                                $(object_wrapper).html(NumPad);
                            } else {
                                NexoAPI.Bootbox().confirm(NumPad, function(action) {
                                    if (action == true) {
                                        $(object).val($(field).val());
                                        $(object).trigger('change');
                                    }
                                });
                            }

                            if ($(field).val() == '') {
                                $(field).val(0);
                            }

                            $(field).focus();

                            $(field).val($(object).val());

                            for (var i = 0; i <= 9; i++) {
                                $('#numpad').find('.numpad' + i).bind('click', function() {
                                    var current_value = $(field).val();
                                    current_value = current_value == '0' ? '' : current_value;
                                    $(field).val(current_value + $(this).val());
                                });
                            }

                            $('.numpadclear').bind('click', function() {
                                $(field).val(0);
                            });

                            $('.numpadplus').bind('click', function() {
                                var numpad_value = NexoAPI.ParseFloat($(field).val());
                                $(field).val(++numpad_value);
                            });

                            $('.numpadminus').bind('click', function() {
                                var numpad_value = NexoAPI.ParseFloat($(field).val());
                                $(field).val(--numpad_value);
                            });

                            $('.numpaddot').bind('click', function() {
                                var current_value = $(field).val();
                                current_value = current_value == '' ? 0 : parseFloat(current_value);
                                //var numpad_value	=	NexoAPI.ParseFloat( $( field ).val() );
                                $(field).val(current_value + '.');
                            });

                            $('.numpaddel').bind('click', function() {
                                var numpad_value = $(field).val();
                                numpad_value = numpad_value.substr(0, numpad_value.length - 1);
                                numpad_value = numpad_value == '' ? 0 : numpad_value;
                                $(field).val(numpad_value);
                            });

                            $(field).blur(function() {
                                if ($(this).val() == '') {
                                    $(this).val(0);
                                }
                            });
                        };

                        /**
                         * Display specific error
                         **/

                        this.showError = function(error_type) {
                            if (error_type == 'ajax_fetch') {
                                NexoAPI.Bootbox().alert('An error occurred during the data recovery');
                            }
                        }

                        /**
                         * Search Item
                         **/

                        this.searchItems = function(value) {
                            this.fetchItem(value, 1, true, 'CODEBAR'); // 'sku-barcode'
                        };

                        /**
                         * Pay,
                         * Proceed payment
                         **/

                        this.pay = function() {
                            if (this.isCartEmpty()) {
                                NexoAPI.Notify().warning('Unable to proceed', 'You cannot validate an order without item. Please add at least one item.');
                                return false;
                            }

                            NexoAPI.Bootbox().dialog({
                                message: '<div id="pay-wrapper"></div>',
                                title: 'Order Payment',
                                buttons: {
                                    success: {
                                        label: 'Confirm & Pay',
                                        className: "btn-success",
                                        callback: function() {
                                            // Submiting order
                                            NexoAPI.events.doAction('submit_order');
                                            return v2Checkout.cartSubmitOrder(v2Checkout.CartPaymentType);
                                        }
                                    },
                                    cancel: {
                                        label: 'Cancel',
                                        className: "btn-default",
                                        callback: function() {
                                            return true;
                                        }
                                    }
                                }
                            });

                            // Old Code Here
                            var dom = '<div class="row pay-box-container">' +
                                    '<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 bootstrap-tab-container">' +
                                    '<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 bootstrap-tab-menu">' +
                                    '<div class="list-group">' +
                                    '<a ' +
                                    'data-tab="cash" ' +
                                    'data-payment-namespace="cash" ' +
                                    'href="#" ' +
                                    'class="list-group-item text-center"' +
                                    'style="border-right:0px">' +
                                    'Cash Payment' +
                                    '</a>' +
                                    //active
                                    '<a ' +
                                    'data-tab="bank" ' +
                                    'data-payment-namespace="bank" ' +
                                    'href="#" ' +
                                    'class="list-group-item text-center"' +
                                    'style="border-right:0px">' +
                                    'Bank Transfer' +
                                    '</a>' +
                                    //active
                                    '<a ' +
                                    'data-tab="stripe" ' +
                                    'data-payment-namespace="stripe" ' +
                                    'href="#" ' +
                                    'class="list-group-item text-center"' +
                                    'style="border-right:0px">' +
                                    'Stripe' +
                                    '</a>' +
                                    //active
                                    '</div>' +
                                    '</div>' +
                                    '<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 bootstrap-tab">' +
                                    '<!-- flight section -->' +
                                    '<div class="bootstrap-tab-content" id="cash">' +
                                    '<div class="content-for-cash">' +
                                    '</div>' +
                                    '</div>' +
                                    // active
                                    '<!-- flight section -->' +
                                    '<div class="bootstrap-tab-content" id="bank">' +
                                    '<div class="content-for-bank">' +
                                    '</div>' +
                                    '</div>' +
                                    // active
                                    '<!-- flight section -->' +
                                    '<div class="bootstrap-tab-content" id="stripe">' +
                                    '<div class="content-for-stripe">' +
                                    '</div>' +
                                    '</div>' +
                                    // active
                                    '</div>' +
                                    '</div>' +
                                    '<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">' +
                                    '<h3 class="text-center">Cart Details</h3>' +
                                    '<div class="checkout-cart-details-wrapper">' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>';

                            $('#pay-wrapper').html(dom);

                            // Footer Filter
                            $('.modal-footer').prepend('<div class="pay_box_footer pull-left">' + NexoAPI.events.applyFilters('pay_box_footer', '') + '</div>');

                            // Width Settings
                            $('#pay-wrapper').closest('.modal-dialog').css({
                                'width': '90%',
                            });

                            // Height Settings

                            var windowHeight = window.innerHeight < 500 ? 500 : window.innerHeight;

                            $('.bootstrap-tab').css({
                                'height': (windowHeight - (90 + Math.abs($('.modal-footer').height() - 5) + Math.abs($('.modal-header').height()))) + 'px',
                                'overflow-y': 'scroll',
                                'overflow-x': 'hidden'
                            });

                            $('.modal-body').css('padding', '0px 15px');

                            $("div.bootstrap-tab-menu>div.list-group>a").click(function(e) {
                                // Change tab color according to current Theme
                                /** var color		=	$( '.navbar' ).css( 'background-color' );
                                 $( this ).css( 'background-color', color );**/
                                e.preventDefault();
                                $(this).siblings('a.active').removeClass("active"); /**.css( 'background-color', 'inherit' ); **/
                                $(this).addClass("active");
                                var index = $(this).attr('data-tab');
                                $("div.bootstrap-tab>div.bootstrap-tab-content").removeClass("active");
                                $("div.bootstrap-tab>div#" + index).addClass("active");
                            });

                            // Get Cart Details
                            $('.checkout-cart-details-wrapper').append($('#cart-details')[0].outerHTML);

                            $('.checkout-cart-details-wrapper table').addClass('table-striped table-bordered');

                            $('.checkout-cart-details-wrapper table tr').each(function() {

                                $(this).removeClass('active danger success');

                                $(this).find('td').removeAttr('colspan');
                                if ($(this).find('td').length > 3) {
                                    $(this).find('td').slice(0, 2).remove();
                                } else {
                                    $(this).find('td').slice(0, 1).remove();
                                }

                                $(this).find('td').eq(0).removeClass('text-right').addClass('text-left');
                            });

                            // end of Cart details

                            /**
                             * Cash Payment
                             **/

                            var cash_dom = '<h3 class="text-center" style="margin-top:5px;">Cash Payment : ' + NexoAPI.DisplayMoney(v2Checkout.CartToPay) + '</h3>' +
                                    '<div class="input-group input-group-lg"> <span class="input-group-addon" id="sizing-addon1">Perceived sum</span> <input type="text" class="form-control" placeholder="Please specify the amount collected..." aria-describedby="sizing-addon1" name="perceived_sum"> </div>' +
                                    '<br><table class="table table-bordered table-striped">' +
                                    '<tr>' +
                                    '<td width="220">To be refunded/invoiced</td><td class="text-right to_payback"></td>' +
                                    '</tr>' +
                                    '<tr>' +
                                    '<td width="220">Receivables</td><td class="text-right cart_creance"></td>' +
                                    '</tr>' +
                                    '</table>' +
                                    '<div id="cash_payment_numpad_wrapper"></div><br><div id="cash_payment_numpad_wrapper"></div>';

                            $('.content-for-cash').append(cash_dom);

                            v2Checkout.showNumPad('[name="perceived_sum"]', '', '#cash_payment_numpad_wrapper', true);

                            $('.numpad').bind('click', function() {
                                v2Checkout.payCashCalculator();
                            });

                            $('[name="perceived_sum"]').bind('keyup', function() {
                                v2Checkout.payCashCalculator();
                            });

                            $('[name="perceived_sum"]').bind('change', function() {
                                v2Checkout.payCashCalculator();
                            });

                            /**
                             * Bank Transfer
                             **/

                            var bank_dom = '<h3 class="text-center" style="margin-top:5px;">Bank Transfer : ' + NexoAPI.DisplayMoney(v2Checkout.CartToPay) + '</h3>' +
                                    '<div class=\"alert alert-info\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\"><i class=\"fa fa-times\"></i></button><i style=\"font-size:18px;margin-right:5px;\" class=\"fa fa-info\"></i> A bank transfer payment fully pays the order. Make sure that the bank transfer is issued on behalf of your point of sale on the occasion of the current sale.</div>';

                            $('.content-for-bank').append(bank_dom);

                            /**
                             * Stripe
                             **/

                            var stripe_dom = '<h3 class="text-center" style="margin-top:5px;">Stripe Payment : ' + NexoAPI.DisplayMoney(v2Checkout.CartToPay) + '</h3>' +
                                    '<div class=\"alert alert-info\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\"><i class=\"fa fa-times\"></i></button><i style=\"font-size:18px;margin-right:5px;\" class=\"fa fa-info\"></i> Activate payment with Stripe. Payment will be full. The card will be firstly charged. If the payment transaction is successful, the order will be validated and registered.</div>' +
                                    '<div class=\"alert alert-info\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\"><i class=\"fa fa-times\"></i></button><i style=\"font-size:18px;margin-right:5px;\" class=\"fa fa-info\"></i> To test stripe, you can use fake credit card numbers. For example you can use: <strong>4242 4242 4242 4242</strong>.<br>Find all the lists of the cards to test on <a href=\"https://stripe.com/docs/testing\">Stripe</a>.</div>' +
                                    '<button class="btn btn-primary" id="pay-with-stripe">Charge Stripe Credit Card</button>';

                            $('.content-for-stripe').append(stripe_dom);

                            $('#pay-with-stripe').on('click', function(e) {
                                // Open Checkout with further options:
                                v2Checkout.stripe.handler.open({
                                    name: 'Shoezie World',
                                    description: v2Checkout.stripe.getDescription(),
                                    amount: v2Checkout.CartToPayLong,
                                    currency: 'USD'
                                });
                                e.preventDefault();
                            });

                            // trigger Pay Box Loaded Action
                            NexoAPI.events.doAction('pay_box_loaded');

                            // Event Set Payment Means
                            $('[data-payment-namespace]').each(function() {
                                $(this).bind('click', function() {
                                    v2Checkout.CartPaymentType = $(this).data('payment-namespace');
                                });
                            });

                            // Default Payment Mean to
                            $('[data-payment-namespace]').eq(0).trigger('click');
                            $('[name="perceived_sum"]').trigger('change');
                        };

                        /**
                         * Pay Calculator
                         * Calculate amount when Cash payment mean is selected
                         **/

                        this.payCashCalculator = function() {

                            this.CartPerceivedSum = Math.abs(NexoAPI.ParseFloat($('[name="perceived_sum"]').val()));

                            // Only numeric are expected on field "perceived_sum", otherwise field take "0";	
                            if (isNaN(this.CartPerceivedSum)) {
                                this.CartPerceivedSum = 0;
                                $('[name="perceived_sum"]').val(this.CartPerceivedSum)
                            }
                            this.CartToPayBack = this.CartPerceivedSum - this.CartToPay < 0 ? 0 : this.CartPerceivedSum - this.CartToPay;


                            if (this.CartToPayBack > 0) {
                                $('.to_payback').html(NexoAPI.DisplayMoney(this.CartToPayBack));
                            } else {
                                $('.to_payback').html(NexoAPI.DisplayMoney(0));
                            }

                            if ((this.CartPerceivedSum - this.CartToPay) < 0) {

                                this.CartCreance = this.CartPerceivedSum - v2Checkout.CartToPay;
                                $('.cart_creance').html(NexoAPI.DisplayMoney(Math.abs(this.CartCreance)));

                            } else {

                                $('.cart_creance').html(NexoAPI.DisplayMoney(0));

                            }
                        }

                        /**
                         * Quick Search Items
                         * @params
                         **/

                        this.quickItemSearch = function(value) {
                            if (value.length <= 3) {
                                $('.filter-add-product').each(function() {
                                    $(this).show();
                                });
                            } else {
                                $('.filter-add-product').show();
                                $('.filter-add-product').each(function() {
                                    // Filter Item
                                    if (
                                            $(this).attr('data-design').search(value.toLowerCase()) == -1 &&
                                            $(this).attr('data-category-name').search(value.toLowerCase()) == -1 &&
                                            $(this).attr('data-codebar').search(value.toLowerCase()) == -1 && // Scan, also item Barcode
                                            $(this).attr('data-sku').search(value.toLowerCase()) == -1  // Scan, also item SKU
                                            ) {
                                        $(this).hide();
                                    }
                                });
                            }
                        }

                        /**
                         * Stripe
                         **/

                        this.stripe = new function() {

                            this.getDescription = function() {
                                return	v2Checkout.CartTotalItems + ': item (s) purchased (s)';
                            }

                            this.run = function() {
                                if (typeof StripeCheckout != 'undefined') {
                                    NexoAPI.Notify().warning('An error has occurred.', 'You haven\'t defined the \"publishable key\" in the stripe settings. The payment using Strip won\'t work.');
                                    this.handler = StripeCheckout.configure({
                                        key: '',
                                        image: 'http://demo-nexopos.tendoo.org/public/modules/nexo/images//nexopos-logo.png',
                                        locale: 'auto',
                                        token: function(token) {
                                            v2Checkout.stripe.proceedPayment(token);
                                        }
                                    });
                                } else {
                                    NexoAPI.Notify().warning('An error has occurred.', 'Stripe is not loaded properly. Payment via the latter will not work. Please refresh the page.');
                                }
                            }

                            /**
                             * Proceed Payment
                             * @params object
                             * @return void
                             **/

                            this.proceedPayment = function(token) {
                                token = _.extend(token, {
                                    'apiKey': '',
                                    'currency': 'USD',
                                    'amount': v2Checkout.CartToPayLong,
                                    'description': this.getDescription()
                                });

                                $.ajax('http://demo-nexopos.tendoo.org/rest/nexo/stripe?store_id=4', {
                                    beforeSend: function() {
                                        v2Checkout.paymentWindow.showSplash();
                                        NexoAPI.Notify().success('Please wait', 'Payment in process...');
                                    },
                                    type: 'POST',
                                    dataType: "json",
                                    data: token,
                                    success: function(data) {
                                        if (data.status == 'payment_success') {
                                            v2Checkout.CartAllowStripeSubmitOrder = true;
                                            $('[data-bb-handler="success"]').trigger('click');
                                        }
                                    },
                                    error: function(data) {
                                        data = $.parseJSON(data.responseText);

                                        if (typeof data.error != 'undefined') {
                                            var message = data.error.message;
                                        } else if (typeof data.httpBody != 'undefined') {
                                            var message = data.jsonBody.error.message;
                                        } else {
                                            var message = 'N/A';
                                        }

                                        v2Checkout.paymentWindow.hideSplash();
                                        NexoAPI.Notify().warning('An error has occurred.', 'The payment could be made. An error occurred during the credit card billing.<br>The server to return this error:' + message);
                                    }
                                });
                            }
                        }

                        /**
                         * Payment	
                         **/

                        this.paymentWindow = new function() {
                            /// Display Splash
                            this.showSplash = function() {
                                if ($('.nexo-overlay').length == 0) {
                                    $('body').append('<div class="nexo-overlay"></div>');
                                    $('.nexo-overlay').css({
                                        'width': '100%',
                                        'height': '100%',
                                        'background': 'rgba(0, 0, 0, 0.5)',
                                        'z-index': 5000,
                                        'position': 'absolute',
                                        'top': 0,
                                        'left': 0,
                                        'display': 'none'
                                    }).fadeIn(500);

                                    $('.nexo-overlay').append('<i class="fa fa-refresh fa-spin nexo-refresh-icon" style="color:#FFF;font-size:50px;"></i>');

                                    $('.nexo-refresh-icon').css({
                                        'position': 'absolute',
                                        'top': '50%',
                                        'left': '50%',
                                        'margin-top': '-25px',
                                        'margin-left': '-25px',
                                        'width': '44px',
                                        'height': '50px'
                                    })
                                }
                            }

                            // Hide splash
                            this.hideSplash = function() {
                                $('.nexo-overlay').fadeOut(300, function() {
                                    $(this).remove();
                                });
                            }

                            this.close = function() {
                                $('[data-bb-handler="cancel"]').trigger('click');
                            };
                        };

                        /**
                         * Refresh Cart
                         *
                         **/

                        this.refreshCart = function() {
                            if (this.isCartEmpty()) {
                                $('#cart-table-notice').show();
                            } else {
                                $('#cart-table-notice').hide();
                            }
                        };

                        /**
                         * Refresh Cart Values
                         *
                         **/

                        this.refreshCartValues = function() {

                            this.calculateCartDiscount();
                            this.calculateCartRistourne();
                            this.calculateCartGroupDiscount();

                            this.CartDiscount = NexoAPI.ParseFloat(this.CartRemise + this.CartRabais + this.CartRistourne + this.CartGroupDiscount);
                            this.CartValueRRR = NexoAPI.ParseFloat(this.CartValue - this.CartDiscount);

                            this.calculateCartVAT();

                            this.CartToPay = (this.CartValueRRR + this.CartVAT);
                            this.CartToPayLong = NexoAPI.ParseFloat(this.CartToPay) + '00';

                            $('#cart-value').html(NexoAPI.DisplayMoney(this.CartValue));
                            $('#cart-vat').html(NexoAPI.DisplayMoney(this.CartVAT));
                            $('#cart-discount').html(NexoAPI.DisplayMoney(this.CartDiscount));
                            $('#cart-topay').html(NexoAPI.DisplayMoney(this.CartToPay));
                        };

                        /**
                         * use saved discount (automatic discount)
                         **/

                        this.restoreCustomRistourne = function() {
                        }

                        /**
                         * Restore default discount (automatic discount)
                         **/

                        this.restoreDefaultRistourne = function() {
                            this.CartRistourneType = 'percent';
                            this.CartRistourneAmount = '';
                            this.CartRistournePercent = '';
                            this.CartRistourneEnabled = false;
                            this.CartRistourne = 0;
                        };

                        /**
                         * Reset Object
                         **/

                        this.resetCartObject = function() {
                            this.ItemsCategories = new Object;
                            this.CartItems = new Array;
                            this.CustomersGroups = new Array;
                            this.ActiveCategories = new Array;
                            // Restore Cart item table
                            this.buildCartItemTable();
                            // Load Customer and groups
                            this.customers.run();
                            // Build Items
                            this.getItems(null, function() {
                                v2Checkout.hideSplash('right');
                            });
                        };

                        /**
                         * Reset Cart
                         **/

                        this.resetCart = function() {

                            this.CartValue = 0;
                            this.CartValueRRR = 0;
                            this.CartVAT = 0;
                            this.CartDiscount = 0;
                            this.CartToPay = 0;
                            this.CartToPayLong = 0;
                            this.CartRabais = 0;
                            this.CartTotalItems = 0;
                            this.CartRemise = 0;
                            this.CartPerceivedSum = 0;
                            this.CartCreance = 0;
                            this.CartToPayBack = 0;

                            this.CartRemiseType = null;
                            this.CartRemiseEnabled = false;
                            this.CartRemisePercent = null;
                            this.CartPaymentType = null;
                            this.CartShadowPriceEnabled = false;
                            this.CartCustomerID = 1;
                            this.CartAllowStripeSubmitOrder = false;

                            this.cartGroupDiscountReset();
                            this.resetCartObject();
                            this.restoreDefaultRistourne();
                            this.refreshCartValues();

                            // @since 2.7.3
                            this.CartNote = '';

                            // @since 2.8.2
                            this.CartMetas = {};

                            // Reset Cart
                            NexoAPI.events.doAction('reset_cart', this);
                        }

                        /**
                         * Run Checkout
                         **/

                        this.run = function() {


                            // Remove Slash First
                            this.paymentWindow.hideSplash();

                            this.fixHeight();
                            this.resetCart();
                            this.initCartDateTime();
                            this.bindHideItemOptions();

                            // @since 2.7.3
                            this.bindAddNote();


                            this.CartStartAnimation = '';

                            $(this.ProductListWrapper).removeClass(this.CartStartAnimation).css('visibility', 'visible').addClass(this.CartStartAnimation);
                            $(this.CartTableWrapper).removeClass(this.CartStartAnimation).css('visibility', 'visible').addClass(this.CartStartAnimation);

                            /*this.getItems(null, function(){ // ALREADY Loaded while resetting cart
                             v2Checkout.hideSplash( 'right' );
                             });*/

                            $(this.CartCancelButton).bind('click', function() {
                                v2Checkout.cartCancel();
                            });

                            $(this.CartDiscountButton).bind('click', function() {
                                v2Checkout.bindAddDiscount();
                            });

                            /**
                             * Search Item Feature
                             **/

                            $(this.ItemSearchForm).bind('submit', function() {
                                v2Checkout.searchItems($('[name="item_sku_barcode"]').val());
                                $('[name="item_sku_barcode"]').val('');
                                return false;
                            });

                            /**
                             * Filter Item
                             **/

                            $(this.ItemSearchForm).bind('keyup', function() {
                                v2Checkout.quickItemSearch($('[name="item_sku_barcode"]').val());
                                console.log('ok');
                            });

                            /**
                             * Cart Item Settings
                             **/

                            $(this.ItemSettings).bind('click', function() {
                                v2Checkout.itemsSettings();
                            });

                            /**
                             * Bind Pay Button
                             **/

                            $(this.CartPayButton).bind('click', function() {
                                v2Checkout.pay();
                            });

                            //
                            $(window).on("beforeunload", function() {
                                if (!v2Checkout.isCartEmpty()) {
                                    return "The order process started. If you continue, you will lose all unsaved information";
                                }
                            })

                            this.stripe.run();
                        }

                        /**
                         * Tools
                         **/

                        this.Tools = new function() {
                            // this.isFloat
                        }
                    };

                    $(document).ready(function(e) {
                        v2Checkout.run();
                    });


                    /**
                     * Filters
                     **/

                    // Default order printable
                    NexoAPI.events.addFilter('test_order_type', function(data) {
                        data[1].order_type == 'nexo_order_comptant';
                        return data;
                    });

                    // Return default data values					
                    NexoAPI.events.addFilter('callback_message', function(data) {
                        // console.log( data );
                        return data;
                    });

                            </script>
                        </div>
                        <div class="meta-row col-lg-3 col-md-3">
                        </div>
                        <div class="meta-row col-lg-3 col-md-3">
                        </div>
                    </div>
                </div>
            </div>
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Tendoo</b> 3.1.3</div>
                <small>Thank you for using Tendoo CMS — 10.32MB in 0.3002 seconds</small></footer>
            <script type="text/javascript">
                        var NexoFirstRun = new function() {
                            this.IsFirstRun = false;
                            this.ShowPrompt = function() {
                                if (this.IsFirstRun == true) {
                                    bootbox.confirm('It is the first time that Nexo is executed. Do you want to create an example of shop activity, to test all the features?<br><br><em>By pressing \"Cancel\", you can enable this option from the settings.</em>', function(action) {
                                        if (action == true) {
                                            tendoo.options.success(function() {
                                                document.location = 'http://demo-nexopos.tendoo.org/dashboard/nexo/settings/reset?hightlight_box=input-group';
                                            }).set('nexo_first_run', true);
                                        } else {
                                            tendoo.options.set('nexo_first_run', true);
                                        }
                                    });
                                }
                            };
                            this.ShowPrompt();
                        };
            </script>
            <script type="text/javascript" src="./Shoezie World › Proceed a sale — NexoPOS_files/bootstrap-tour.min.js"></script>
            <link rel="stylesheet" media="all" href="./Shoezie World › Proceed a sale — NexoPOS_files/bootstrap-tour.min.css">
            <style type="text/css">
                .ar-up {
                    width: 0;
                    height: 0;
                    border-left: 5px solid transparent;
                    border-right: 5px solid transparent;
                    border-bottom: 15px solid #ADFF77;
                    top: -17px;
                    margin-right: 5px;
                    position: relative;
                }
                .ar-down {
                    width: 0;
                    height: 0;
                    border-left: 5px solid transparent;
                    border-right: 5px solid transparent;
                    border-top: 15px solid #FF8080;
                    top: 17px;
                    margin-right: 5px;
                    position: relative;
                }
                .ar-invert-up {
                    width: 0;
                    height: 0;
                    border-left: 5px solid transparent;
                    border-right: 5px solid transparent;
                    border-top: 15px solid #ADFF77;
                    top: 17px;
                    margin-right: 5px;
                    position: relative;
                }
                .ar-invert-down {
                    width: 0;
                    height: 0;
                    border-left: 5px solid transparent;
                    border-right: 5px solid transparent;
                    border-bottom: 15px solid #FF8080;
                    top: -17px;
                    margin-right: 5px;
                    position: relative;
                }
            </style>
            <script type="text/javascript">

                        "use strict";

                        $('[data-meta-namespace]').find('[data-widget]').bind('click', function() {
                            tendoo.options.merge(
                                    'meta_status[' + $(this).closest('[data-meta-namespace]').data('meta-namespace') + ']',
                                    $(this).closest('[data-meta-namespace]').hasClass('collapsed-box') ? 'uncollapsed-box' : 'collapsed-box',
                                    true
                                    );
                        });
            </script>

            <aside class="control-sidebar control-sidebar-dark" style="position: fixed; max-height: 100%; overflow: auto; padding-bottom: 50px;"> 
                <!-- Create the tabs -->
                <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
                    <li class="active"><a href="http://demo-nexopos.tendoo.org/dashboard/stores/4/nexo/registers/__use/default#control-sidebar-theme-demo-options-tab" data-toggle="tab"><i class="fa fa-wrench"></i></a></li>
                    <li><a href="http://demo-nexopos.tendoo.org/dashboard/stores/4/nexo/registers/__use/default#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
                    <li><a href="http://demo-nexopos.tendoo.org/dashboard/stores/4/nexo/registers/__use/default#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content"> 
                    <!-- Home tab content -->
                    <div class="tab-pane" id="control-sidebar-home-tab">
                        <h3 class="control-sidebar-heading">Recent Activity</h3>
                        <ul class="control-sidebar-menu">
                            <li> <a href="javascript::;"> <i class="menu-icon fa fa-birthday-cake bg-red"></i>
                                    <div class="menu-info">
                                        <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>
                                        <p>Will be 23 on April 24th</p>
                                    </div>
                                </a> </li>
                            <li> <a href="javascript::;"> <i class="menu-icon fa fa-user bg-yellow"></i>
                                    <div class="menu-info">
                                        <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>
                                        <p>New phone +1(800)555-1234</p>
                                    </div>
                                </a> </li>
                            <li> <a href="javascript::;"> <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>
                                    <div class="menu-info">
                                        <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>
                                        <p>nora@example.com</p>
                                    </div>
                                </a> </li>
                            <li> <a href="javascript::;"> <i class="menu-icon fa fa-file-code-o bg-green"></i>
                                    <div class="menu-info">
                                        <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>
                                        <p>Execution time 5 seconds</p>
                                    </div>
                                </a> </li>
                        </ul>
                        <!-- /.control-sidebar-menu -->

                        <h3 class="control-sidebar-heading">Tasks Progress</h3>
                        <ul class="control-sidebar-menu">
                            <li> <a href="javascript::;">
                                    <h4 class="control-sidebar-subheading"> Custom Template Design <span class="label label-danger pull-right">70%</span> </h4>
                                    <div class="progress progress-xxs">
                                        <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                                    </div>
                                </a> </li>
                            <li> <a href="javascript::;">
                                    <h4 class="control-sidebar-subheading"> Update Resume <span class="label label-success pull-right">95%</span> </h4>
                                    <div class="progress progress-xxs">
                                        <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                                    </div>
                                </a> </li>
                            <li> <a href="javascript::;">
                                    <h4 class="control-sidebar-subheading"> Laravel Integration <span class="label label-waring pull-right">50%</span> </h4>
                                    <div class="progress progress-xxs">
                                        <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                                    </div>
                                </a> </li>
                            <li> <a href="javascript::;">
                                    <h4 class="control-sidebar-subheading"> Back End Framework <span class="label label-primary pull-right">68%</span> </h4>
                                    <div class="progress progress-xxs">
                                        <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                                    </div>
                                </a> </li>
                        </ul>
                        <!-- /.control-sidebar-menu --> 

                    </div>
                    <div id="control-sidebar-theme-demo-options-tab" class="tab-pane active">
                        <div>
                            <h4 class="control-sidebar-heading">Layout Options</h4>
                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    <input type="checkbox" data-layout="fixed" class="pull-right" checked="checked">
                                    Fixed layout</label>
                                <p>Activate the fixed layout. You can't use fixed and boxed layouts together</p>
                            </div>
                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    <input type="checkbox" data-layout="layout-boxed" class="pull-right">
                                    Boxed Layout</label>
                                <p>Activate the boxed layout</p>
                            </div>
                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    <input type="checkbox" data-layout="sidebar-collapse" class="pull-right">
                                    Toggle Sidebar</label>
                                <p>Toggle the left sidebar's state (open or collapse)</p>
                            </div>
                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    <input type="checkbox" data-enable="expandOnHover" class="pull-right">
                                    Sidebar Expand on Hover</label>
                                <p>Let the sidebar mini expand on hover</p>
                            </div>
                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    <input type="checkbox" data-controlsidebar="control-sidebar-open" class="pull-right">
                                    Toggle Right Sidebar Slide</label>
                                <p>Toggle between slide over content and push content effects</p>
                            </div>
                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    <input type="checkbox" data-sidebarskin="toggle" class="pull-right">
                                    Toggle Right Sidebar Skin</label>
                                <p>Toggle between dark and light skins for the right sidebar</p>
                            </div>
                            <h4 class="control-sidebar-heading">Skins</h4>
                            <ul class="list-unstyled clearfix">
                                <li style="float:left; width: 33.33333%; padding: 5px;"><a href="javascript:void(0);" data-skin="skin-blue" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                        <div><span style="display:block; width: 20%; float: left; height: 7px; background: #367fa9;"></span><span class="bg-light-blue" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                                        <div><span style="display:block; width: 20%; float: left; height: 20px; background: #222d32;"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span></div>
                                    </a>
                                    <p class="text-center no-margin">Blue</p>
                                </li>
                                <li style="float:left; width: 33.33333%; padding: 5px;"><a href="javascript:void(0);" data-skin="skin-black" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                        <div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix"><span style="display:block; width: 20%; float: left; height: 7px; background: #fefefe;"></span><span style="display:block; width: 80%; float: left; height: 7px; background: #fefefe;"></span></div>
                                        <div><span style="display:block; width: 20%; float: left; height: 20px; background: #222;"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span></div>
                                    </a>
                                    <p class="text-center no-margin">Black</p>
                                </li>
                                <li style="float:left; width: 33.33333%; padding: 5px;"><a href="javascript:void(0);" data-skin="skin-purple" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                        <div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-purple-active"></span><span class="bg-purple" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                                        <div><span style="display:block; width: 20%; float: left; height: 20px; background: #222d32;"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span></div>
                                    </a>
                                    <p class="text-center no-margin">Purple</p>
                                </li>
                                <li style="float:left; width: 33.33333%; padding: 5px;"><a href="javascript:void(0);" data-skin="skin-green" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                        <div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-green-active"></span><span class="bg-green" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                                        <div><span style="display:block; width: 20%; float: left; height: 20px; background: #222d32;"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span></div>
                                    </a>
                                    <p class="text-center no-margin">Green</p>
                                </li>
                                <li style="float:left; width: 33.33333%; padding: 5px;"><a href="javascript:void(0);" data-skin="skin-red" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                        <div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-red-active"></span><span class="bg-red" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                                        <div><span style="display:block; width: 20%; float: left; height: 20px; background: #222d32;"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span></div>
                                    </a>
                                    <p class="text-center no-margin">Red</p>
                                </li>
                                <li style="float:left; width: 33.33333%; padding: 5px;"><a href="javascript:void(0);" data-skin="skin-yellow" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                        <div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-yellow-active"></span><span class="bg-yellow" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                                        <div><span style="display:block; width: 20%; float: left; height: 20px; background: #222d32;"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span></div>
                                    </a>
                                    <p class="text-center no-margin">Yellow</p>
                                </li>
                                <li style="float:left; width: 33.33333%; padding: 5px;"><a href="javascript:void(0);" data-skin="skin-blue-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                        <div><span style="display:block; width: 20%; float: left; height: 7px; background: #367fa9;"></span><span class="bg-light-blue" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                                        <div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc;"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span></div>
                                    </a>
                                    <p class="text-center no-margin" style="font-size: 12px">Blue Light</p>
                                </li>
                                <li style="float:left; width: 33.33333%; padding: 5px;"><a href="javascript:void(0);" data-skin="skin-black-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                        <div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix"><span style="display:block; width: 20%; float: left; height: 7px; background: #fefefe;"></span><span style="display:block; width: 80%; float: left; height: 7px; background: #fefefe;"></span></div>
                                        <div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc;"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span></div>
                                    </a>
                                    <p class="text-center no-margin" style="font-size: 12px">Black Light</p>
                                </li>
                                <li style="float:left; width: 33.33333%; padding: 5px;"><a href="javascript:void(0);" data-skin="skin-purple-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                        <div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-purple-active"></span><span class="bg-purple" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                                        <div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc;"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span></div>
                                    </a>
                                    <p class="text-center no-margin" style="font-size: 12px">Purple Light</p>
                                </li>
                                <li style="float:left; width: 33.33333%; padding: 5px;"><a href="javascript:void(0);" data-skin="skin-green-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                        <div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-green-active"></span><span class="bg-green" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                                        <div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc;"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span></div>
                                    </a>
                                    <p class="text-center no-margin" style="font-size: 12px">Green Light</p>
                                </li>
                                <li style="float:left; width: 33.33333%; padding: 5px;"><a href="javascript:void(0);" data-skin="skin-red-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                        <div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-red-active"></span><span class="bg-red" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                                        <div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc;"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span></div>
                                    </a>
                                    <p class="text-center no-margin" style="font-size: 12px">Red Light</p>
                                </li>
                                <li style="float:left; width: 33.33333%; padding: 5px;"><a href="javascript:void(0);" data-skin="skin-yellow-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                        <div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-yellow-active"></span><span class="bg-yellow" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                                        <div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc;"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span></div>
                                    </a>
                                    <p class="text-center no-margin" style="font-size: 12px;">Yellow Light</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- /.tab-pane --> 
                    <!-- Stats tab content -->
                    <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
                    <!-- /.tab-pane --> 
                    <!-- Settings tab content -->
                    <div class="tab-pane" id="control-sidebar-settings-tab">
                        <form method="post">
                            <h3 class="control-sidebar-heading">General Settings</h3>
                            <div class="form-group">
                                <label class="control-sidebar-subheading"> Report panel usage
                                    <input type="checkbox" class="pull-right" checked="">
                                </label>
                                <p> Some information about this general settings option </p>
                            </div>
                            <!-- /.form-group -->

                            <div class="form-group">
                                <label class="control-sidebar-subheading"> Allow mail redirect
                                    <input type="checkbox" class="pull-right" checked="">
                                </label>
                                <p> Other sets of options are available </p>
                            </div>
                            <!-- /.form-group -->

                            <div class="form-group">
                                <label class="control-sidebar-subheading"> Expose author name in posts
                                    <input type="checkbox" class="pull-right" checked="">
                                </label>
                                <p> Allow the user to show his name in blog posts </p>
                            </div>
                            <!-- /.form-group -->

                            <h3 class="control-sidebar-heading">Chat Settings</h3>
                            <div class="form-group">
                                <label class="control-sidebar-subheading"> Show me as online
                                    <input type="checkbox" class="pull-right" checked="">
                                </label>
                            </div>
                            <!-- /.form-group -->

                            <div class="form-group">
                                <label class="control-sidebar-subheading"> Turn off notifications
                                    <input type="checkbox" class="pull-right">
                                </label>
                            </div>
                            <!-- /.form-group -->

                            <div class="form-group">
                                <label class="control-sidebar-subheading"> Delete chat history <a href="javascript::;" class="text-red pull-right"><i class="fa fa-trash-o"></i></a> </label>
                            </div>
                            <!-- /.form-group -->
                        </form>
                    </div>
                    <!-- /.tab-pane --> 
                </div>
            </aside>

            <div class="control-sidebar-bg" style="position: fixed; height: auto;"></div>

        </div>



        <div role="log" aria-live="assertive" aria-relevant="additions" class="ui-helper-hidden-accessible"><div>Walkin Customer</div></div></body></html>