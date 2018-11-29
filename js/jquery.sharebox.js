(function($){"use strict";var name="sharebox";var Self=function(options){var Defaults=Self.defaults,Services=Self.services;this.each(function(){var $this=$(this),attrs={url:$this.data("url"),title:$this.data("title"),services:$this.data("services")},settings=$.extend({},Defaults,attrs,options),services=settings.services.match(/\S+/g);var $ul=$this.find("ul.sharebox-buttons");if(!$ul.length)
$ul=$("<ul></ul>").addClass("sharebox-buttons row pull-right").appendTo($this);$.each(services,function(i,name){name=name.replace("google+","google-plus");var Service=Services[name];if(!Service)return;var $li=$ul.find("li.share-"+name);if(!$li.length)
$li=$("<li></li>").addClass("social share-"+name).appendTo($ul);$li.append($("<a></a>").attr({href:($.isFunction(Service.url)?Service.url(settings):Service.url),title:(Service.label||name),class:('social-icon')}).data({width:Service.width,height:Service.height}).click(function(){return Service.click.call(this,settings);}).append($("<i></i>").addClass("fa fa-"+name)));});});return this;};$(document).ready(function(){$(".sharebox").sharebox();});Self.popup=function(options){var $this=$(this),url=$this.attr("href"),width=$this.data("width")||400,height=$this.data("height")||300;window.open(url,"share","menubar=no,status=no,resizable=yes,menubar=no,width={WIDTH},height={HEIGHT}".replace("{WIDTH}",width).replace("{HEIGHT}",height));return false;};Self.defaults={url:document.location.href,title:$(document).attr("title"),services:"facebook twitter google+ linkedin whatsapp "};Self.services={whatsapp:{label:"Whatsapp",width:720,height:320,url:function(options){return"https://web.whatsapp.com/?url={URL}&title={TITLE}".replace("{URL}",encodeURIComponent(options.url)).replace("{TITLE}",encodeURIComponent(options.title));},click:Self.popup},facebook:{label:"Facebook",width:500,height:300,url:function(options){return"https://www.facebook.com/sharer/sharer.php?u={URL}&t={TITLE}".replace("{URL}",encodeURIComponent(options.url)).replace("{TITLE}",encodeURIComponent(options.title));},click:Self.popup},"google-plus":{label:"Google+",width:500,height:460,url:function(options){return"https://plus.google.com/share?url={URL}".replace("{URL}",encodeURIComponent(options.url));},click:Self.popup},linkedin:{label:"LinkedIn",width:500,height:400,url:function(options){return"https://www.linkedin.com/shareArticle?mini=true&url={URL}&title={TITLE}&summary=&source=".replace("{URL}",encodeURIComponent(options.url)).replace("{TITLE}",encodeURIComponent(options.title));},click:Self.popup},pinterest:{label:"Pinterest",width:500,height:300,url:function(options){return"https://pinterest.com/pin/create/link/?url={URL}&description={TITLE}".replace("{URL}",encodeURIComponent(options.url)).replace("{TITLE}",encodeURIComponent(options.title));},click:Self.popup},pocket:{label:"Pocket",width:null,height:null,url:function(options){return"https://getpocket.com/save?url={URL}&title={TITLE}".replace("{URL}",encodeURIComponent(options.url)).replace("{TITLE}",encodeURIComponent(options.title));},click:Self.popup},reddit:{label:"Reddit",width:500,height:300,url:function(options){return"https://reddit.com/submit?url={URL}&title={TITLE}".replace("{URL}",encodeURIComponent(options.url)).replace("{TITLE}",encodeURIComponent(options.title));},click:Self.popup},stumbleupon:{label:"StumbleUpon",width:500,height:300,url:function(options){return"https://www.stumbleupon.com/submit?url={URL}&title={TITLE}".replace("{URL}",encodeURIComponent(options.url)).replace("{TITLE}",encodeURIComponent(options.title));},click:Self.popup},tumblr:{label:"Tumblr",width:500,height:300,url:function(options){return"https://www.tumblr.com/share/link?url={URL}&name={TITLE}&description=".replace("{URL}",encodeURIComponent(options.url)).replace("{TITLE}",encodeURIComponent(options.title));},click:Self.popup},twitter:{label:"Twitter",width:500,height:300,url:function(options){return"https://twitter.com/intent/tweet?url={URL}&text={TITLE} vikas".replace("{URL}",encodeURIComponent(options.url)).replace("{TITLE}",encodeURIComponent(options.title));},click:Self.popup},print:{label:"Print",url:"#",click:function(){window.print();return false;}}};$.fn[name]=Self;if(window.location.href.match('https://twitter.com/intent/tweet?url={URL}&text={TITLE}')){alert('HI');}})(jQuery);