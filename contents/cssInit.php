<style type="text/css" media="screen">

.clearfix::after {
    content: "";
    clear: both;
    display: table;
}

#dashboard-widgets > div.col {width: 49%; float: left;}

@media screen and (max-width: 1024px) {
#dashboard-widgets > div.col {width: 100%; float: none;}
}


/*LOGO*/
#logo {max-width: 100%; height: auto; display: block; margin: 0 0 20px;}

.toplevel-leadtracker .ic_ltk{ background:transparent url(<?php echo plugins_url( 'ui_wp_ltk.png', __FILE__ ); ?>) no-repeat right -231px;}
.inside{padding:10px!important;}
.inside p{ line-height:20px; padding-bottom:10px; margin:5px 0 0 5px; }
.inside .login .cnt {}
.inside .login .btn {cursor:pointer;display:flex;flex-direction:column;align-items: center; text-decoration:none; color: inherit; border:1px solid #333; border-style: dotted;padding:5px 10px; width:50px}
.inside .login a.know {margin-top:10px;display:block;}
.inside .login .btn img {display:inline-block; max-width:40px;width:auto;}

.ltk-menu-image{float:left; width:28px; height:28px; background:transparent url(<?php echo plugins_url( 'ui_wp_ltk.png', __FILE__ ); ?>) no-repeat right -256px;}

.rep_ltk { float:left; width:49%; margin:0 5px;}
.rep_ltk div{ background:#FFFBCC url(<?php echo plugins_url( 'ui_wp_ltk.png', __FILE__ ); ?>) no-repeat -637px -103px; height:80px; border:1px solid #E6DB55; width:98%; min-width:550px; max-width: 782px;}
.rep_ltk div p{ padding:15px 15px 0 181px; }
.rep_ltk div p a{ color:#60A51B; font-weight:bold;}
.rep_ltk div p a:hover{ color:#D54E21;}

#icon-leadtracker{ background:url(<?php echo plugins_url( 'ui_wp_ltk.png', __FILE__ ); ?>) no-repeat right top;}

.ltk_lst{ margin:0;}

.postbox-container a { color: #00a8e1; outline: none;}
.postbox-container a:focus {outline: none; box-shadow: none;}

/*#dashboard-widgets-wrap{ min-width:950px;}*/

#dashboard_right_now ul h4 {margin-bottom: 15px; font-size: 15px; font-weight: 600}
#dashboard_right_now ul.ltk_lst li {display: block;}
#dashboard_right_now ul.ltk_lst li a {font-size: 15px;}
#dashboard_right_now ul.ltk_lst li a:before {display: none;}
#dashboard_right_now ul.ltk_lst li .dashicons:before {color: #00a8e1; transition: .2s}

#dashboard_right_now .inside .ul-cnt{ width:100%; }
#dashboard_right_now .inside .ul-cnt li{ width:calc(100% - 20px); list-style:circle;margin-left:20px;}


/*hover*/
.postbox-container a:hover, a:hover .dashicons:before {color: #333!important;}

/*box title*/
.postbox h2.hndle {padding: 10px 20px; cursor: default!important;}
.postbox h3{ cursor:auto!important;}

.postbox h2 .status {float: right;}
.postbox h2 .on {color:#00a8e1; font-size:12px; float:right; padding:2px 0 2px 0; text-align:left;}
.postbox h2 .on span{opacity: .8; background:url(<?php echo plugins_url( 'ui_wp_ltk.png', __FILE__ ); ?>) no-repeat -785px -336px; display:block; float:left; width:12px; height:16px; margin-top:-2px; margin-right:6px;}

.postbox h2 .off{ color:#9c9a9a; font-size:12px; float:right; padding:2px 0 2px 0; text-align:left;}
.postbox h2 .off span {background:url(<?php echo plugins_url( 'ui_wp_ltk.png', __FILE__ ); ?>) no-repeat -785px -365px; display:block; float:left; width:12px; height:16px; margin-top:-2px; margin-right:6px;}

/*box content*/
.postbox .inside {padding: 15px 25px !important;}
.postbox-container .meta-box-sortables{ min-height:150px;}
#dashboard-widgets .postbox-container{width:99%; display:block;}
.clearme{ clear:both;}

/*sobre*/
.postbox.sobre .inside {padding: 17px 35px!important}
.postbox.sobre .inside p {margin: 0; padding-bottom: 15px;}

/*config*/
.inside .sing-up {margin-top: 15px;}

/*analytics dash*/
.inside.analytics-dash {} /*189681*/
.inside.analytics-dash .dash {width: 100%; max-width: 365px; float: left; transition: .3s}
.inside.analytics-dash .dash img {max-width: 100%; height: auto; display: block;}
.inside.analytics-dash .dash:hover {opacity: .9;}
.inside.analytics-dash .texto {width: calc(100% - 370px); width: -webkit-calc(100% - 370px); float: right; margin-top: 10%; padding-left: 25px; box-sizing: border-box;}
.inside.analytics-dash .texto h3 {font-size: 20px!important; font-weight: 600!important; margin-bottom: 15px!important;}
.inside.analytics-dash .texto p {font-size: 16px; margin: 0}

@media screen and (max-width: 1550px) {
	.inside.analytics-dash .dash {width: 47%;}
	.inside.analytics-dash .texto {width: 50%;}
}

@media screen and (max-width: 520px) {
	.inside.analytics-dash .dash {width: 100%; max-width: 300px; margin: auto; float: none; text-align: center; display: block;}
	.inside.analytics-dash .texto {width: 100%; max-width: 250px; float: none; margin: 15px auto 0; padding-left: 0; text-align: center;}
}


.id_ltk .inside {padding: 15px 25px 22px!important;}
.id_ltk .inside p {margin: 0}
.id_ltk .inside form {width: 100%; display: inline-block; vertical-align: top; padding: 0 10px; box-sizing: border-box;}
.id_ltk .inside .logout {margin-top:15px;margin-left:10px;display:block}

.cnt_ltk {}

.id_ltk input, .cnt_ltk input {padding: 4px 10px; font-size:15px; width:131px;}
#idNvg {background:#FFF url(<?php echo plugins_url( 'ui_wp_ltk.png', __FILE__ ); ?>) no-repeat 7px -329px; padding: 3px 5px 3px 30px;}
.id_ltk input#emNvg {padding: 4px 10px;}
.cnt_ltk input{margin-top:5px;}
#idNvg::placeholder {color: #999;}
/*div.postbox.id_ltk button.button, div.postbox.cnt_ltk button.button{height:36px!important; top: 4px; position: relative;}*/

@media screen and (max-width: 520px) {
	.id_ltk .inside form {width: 100%; display: block; padding: 0 10px; box-sizing: border-box;}
}

/*create account*/
.inside.sing-up {display: table; padding: 15px 25px 25px !important;}
.inside.sing-up p {margin: 0;}
.inside.sing-up .campo {margin-bottom: 15px;}
.inside.sing-up .campo.inline {display: inline-block;}
.inside.sing-up .campo.inline:first-of-type {padding-right: 15px;}
.inside.sing-up .campo:last-child {margin-bottom: 0}
.inside.sing-up .campo label {display: block;}
.inside.sing-up .campo input {width: 100%;}

.pn_ltk {}

.updtSucess{ padding:0 0 7px 23px!important; margin:0; color:#090; background:transparent url(<?php echo plugins_url( 'ui_wp_ltk.png', __FILE__ ); ?>) no-repeat -783px -430px;}
.updtFail{ padding:0 0 7px 23px!important; margin:0; color:#f82b33; background:transparent url(<?php echo plugins_url( 'ui_wp_ltk.png', __FILE__ ); ?>) no-repeat -783px -454px;}

.inside .ltkerror { clear: both; margin-top: -5px; color: red; font-weight: bold; }
</style>