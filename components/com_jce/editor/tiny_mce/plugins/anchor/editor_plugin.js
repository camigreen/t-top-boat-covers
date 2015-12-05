/* JCE Editor - 2.5.7 | 10 September 2015 | http://www.joomlacontenteditor.net | Copyright (C) 2006 - 2015 Ryan Demmer. All rights reserved | GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html */
(function(){var DOM=tinymce.DOM,Event=tinymce.dom.Event,is=tinymce.is,each=tinymce.each;var Node=tinymce.html.Node;var VK=tinymce.VK,BACKSPACE=VK.BACKSPACE,DELETE=VK.DELETE;tinymce.create('tinymce.plugins.AnchorPlugin',{init:function(ed,url){this.editor=ed;this.url=url;var self=this;function isAnchor(n){return ed.dom.getParent(n,'a.mceItemAnchor');}
ed.settings.allow_html_in_named_anchor=true;ed.addCommand('mceInsertAnchor',function(ui,value){return self._insertAnchor(value);});ed.onNodeChange.add(function(ed,cm,n,co){var s=isAnchor(n);ed.dom.removeClass(ed.dom.select('.mceItemAnchor.mceItemSelected'),'mceItemSelected');cm.setActive('anchor',s);if(s){ed.dom.addClass(ed.dom.select('.mceItemAnchor'),'mceItemSelected');}});ed.onKeyDown.add(function(ed,e){if(e.keyCode===VK.BACKSPACE||e.keyCode===VK.DELETE){self._removeAnchor(e);}});ed.onInit.add(function(){if(ed.theme&&ed.theme.onResolveName){ed.theme.onResolveName.add(function(theme,o){var n=o.node,v,href=n.href;if(o.name==='a'&&(!href||href.charAt(0)=='#')&&(n.name||n.id)){v=n.name||n.id;}
if(v){o.name='a#'+v;}});}
if(!ed.settings.compress.css)
ed.dom.loadCSS(url+"/css/content.css");});ed.onPreInit.add(function(){ed.parser.addNodeFilter('a',function(nodes){for(var i=0,len=nodes.length;i<len;i++){var node=nodes[i],href=node.attr('href'),cls=node.attr('class')||'',name=node.attr('name')||node.attr('id');if((!href||href.charAt(0)=='#')&&name){if(!cls||/mceItemAnchor/.test(cls)===false){cls+=' mceItemAnchor';node.attr('class',tinymce.trim(cls));}}}});});ed.onBeforeSetContent.add(function(ed,o){o.content=o.content.replace(/<a id="([^"]+)"><\/a>/gi,'<a id="$1">\uFEFF</a>');});},_removeAnchor:function(e){var ed=this.editor,s=ed.selection,n=s.getNode();if(!s.isCollapsed()&&ed.dom.getParent(n,'a.mceItemAnchor')){ed.undoManager.add();ed.formatter.remove('link');if(e){e.preventDefault();}}},_getAnchor:function(){var ed=this.editor,n=ed.selection.getNode(),v;n=ed.dom.getParent(n,'a.mceItemAnchor');v=ed.dom.getAttrib(n,'name')||ed.dom.getAttrib(n,'id');return v;},_insertAnchor:function(v){var ed=this.editor,attrib;if(!v){ed.windowManager.alert('anchor.invalid');return false;}
if(!/^[a-z][a-z0-9\-\_:\.]*$/i.test(v)){ed.windowManager.alert('anchor.invalid');return false;}
attrib='name';if(ed.settings.schema!=='html4'){attrib='id';}
var n=ed.selection.getNode();var at={'class':'mceItemAnchor'};if(n=ed.dom.getParent(n,'A')){at[attrib]=v;ed.dom.setAttribs(n,at);}else{if(ed.dom.select('a['+attrib+'="'+v+'"], img[data-mce-name="'+v+'"], img[id="'+v+'"]',ed.getBody()).length){ed.windowManager.alert('anchor.exists');return false;}
if(ed.selection.isCollapsed()){at[attrib]=v;ed.execCommand('mceInsertContent',0,ed.dom.createHTML('a',{id:'__mce_tmp'},'\uFEFF'));n=ed.dom.get('__mce_tmp');at.id=at.id||null;ed.dom.setAttribs(n,at);ed.selection.select(n);}else{at[attrib]=v;ed.execCommand('mceInsertLink',false,'#mce_temp_url#',{skip_undo:1});at.href=at['data-mce-href']=null;each(ed.dom.select('a[href="#mce_temp_url#"]'),function(link){ed.dom.setAttribs(link,at);});}}
ed.execCommand("mceEndUndoLevel");ed.nodeChanged();return true;},createControl:function(n,cm){var self=this,ed=this.editor;switch(n){case'anchor':var content=DOM.create('div');var fieldset=DOM.add(content,'fieldset',{},'<legend>'+ed.getLang('anchor.desc','Insert / Edit Anchor')+'</legend>');DOM.add(fieldset,'label',{'for':ed.id+'_anchor'},ed.getLang('anchor.name','Name'));var input=DOM.add(fieldset,'input',{type:'text',id:ed.id+'_anchor'});var c=new tinymce.ui.ButtonDialog(cm.prefix+'anchor',{title:ed.getLang('anchor.desc','Inserts an Anchor'),'class':'mce_anchor','content':content,'width':250,'buttons':[{title:ed.getLang('insert','Insert'),id:'insert',click:function(e){return self._insertAnchor(input.value);},scope:self},{title:ed.getLang('anchor.remove','Remove'),id:'remove',click:function(e){if(!DOM.hasClass(e.target,'disabled')){self._removeAnchor();}
return true;},scope:self}]},ed);c.onShowDialog.add(function(){input.value='';var label=ed.getLang('insert','Insert');var v=self._getAnchor();if(v){input.value=v;label=ed.getLang('update','Update');}
c.setActive(!!v);c.setButtonDisabled('remove',!v);c.setButtonLabel('insert',label);input.focus();});c.onHideDialog.add(function(){input.value='';});ed.onRemove.add(function(){c.destroy();});return cm.add(c);break;}
return null;},getInfo:function(){return{longname:'Anchor',author:'Ryan Demmer',authorurl:'http://www.joomlacontenteditor.net',infourl:'http://www.joomlacontenteditor.net',version:'2.5.7'};}});tinymce.PluginManager.add('anchor',tinymce.plugins.AnchorPlugin);})();