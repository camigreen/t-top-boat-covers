<?php 
/** 
 * @package JMAP::SOURCES::administrator::components::com_jmap
 * @subpackage views
 * @subpackage help
 * @subpackage tmpl
 * @author Joomla! Extensions Store
 * @copyright (C) 2014 - Joomla! Extensions Store
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html  
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' ); 
?>
<div>
	<span class="bold">Data sources concept</span> is the basis of JSitemap PRO. 
	With this innovative and powerful functionality you can <span class="bold">insert every type of content</span> in your
	sitemap without the need to use third party plugins for every extension you want to grab data from to be showed inside sitemap. <br />
	To reach data sources management you simply click on the first icon in
	JSitemap PRO control panel, and it will be showed the list of currently
	available data sources for sitemap. <br /> Basically data sources can
	be of <span class="bold">three different types:</span>
	<ul>
		<li><span class="bold">Content:</span> this is an <span class="bold">auto generated data source</span>, and it
			represents inside sitemap all your Joomla! contents splitted by
			categories. You will see always 1 data source for this type and you
			can only edit settings for this type of data source as it's
			predefined and auto-managed by component.</li>
		<li><span class="bold">Menu:</span> this is an <span class="bold">auto generated data source</span>, and every
			instance of it represents a menu that you created in your Joomla!
			CMS. JSitemap PRO syncronize automatically these data sources to your
			menus, so you will have many data source of type 'menu' as your
			Joomla! menus. Every time you create a new menu, a new data source of
			type 'menu' will be available in JSitemap PRO list. so that you can
			decide to publish it and show its links inside sitemap, easy enough?</li>
		<li><span class="bold">User:</span> this type of data sources is the most interesting one,
			because it will let you get data from virtually <span class="bold">every type of
			extension</span> installed that use Joomla! database. 
			You can create user defined data sources in two way, using the fully automated process based on <span class="bold">one click Wizard</span>,
			or choose to <span class="bold">start from scratch a new one</span> for example if your extensions is still not available inside wizard.
			You can contact our support asking for assist or requiring that extension you are using will be available in wizard process.</li>
	</ul>
	<img src="components/com_jmap/images/documentation/datasources_list.jpg" alt="list data sources"/>
    <br />
	As you can see from picture there are 1
	data source for 'content', several data sources for 'menu', and several data sources
	of type 'user'. This will mean that inside sitemap will be visible the
	contents tree splitted into categories, the menu items for system
	menus, and items taken from third party components that are user defined types. 
	In this way you can send to search engines a sitemap
	containing also the links managed by Sobipro, Virtuemart, etc components, all without
	using specific sitemap plugins!<br /> There are no
	limits to what you can insert in your sitemap, every installed
	component that uses Joomla! database can be queried for links
	generation to be placed inside sitemap. This means that you can
	optimize search engines indexing with all your Joomla! entities on your
	own, using a single component without looking for specific plugins.<br /><br />
    
    Once installed JSitemap PRO you will get by default menu and content type data sources already created,
    and your sitemap will be immediatly built on that data.
    If you need to add some other extensions as a source for sitemap, the first step is <span class="bold">click on button 'New data source'.</span>
    This will <span class="bold">show up the Wizard control panel</span> where you can choose type of data source you want to be created automatically by JSitemap for common available extensions.
    <img src="components/com_jmap/images/documentation/wizard.jpg" alt="wizard"/>
    <br /><br />
	If you choose an <span class="bold">available data source for common extensions</span>, after clicking on icon button you will be shown a message and shortly
	once finished creation process you will be redirected to data sources list and informed about results of this operation.
	At this point the links requested will be <span class="bold">already available in your sitemap.</span>
	However you could need to <span class="bold">fine tune some parameter for the data source</span>, so you should enter in <span class="bold">edit mode</span> to display control panel for single data source, see picture below.
	<img src="components/com_jmap/images/documentation/menu_itemid.jpg" alt="menu itemid"/>
	<br/>
	Most frequently you need to <span class="bold">assign a menu item</span> once created a new user defined data source. This is done to <span class="bold">avoid to have unrewritten SEF chunks</span> in your links,
	for example <span class="bold">'component/com_virtuemart'</span>. In this example selecting the menu item 'Virtuemart shop' we specify that links for sitemap should have to <span class="bold">replace
	'component/com_virtuemart' with that menu alias</span>, for example <span class="bold">'shop'</span>.
	So instead of having links 
	<p style="font-style:italic">'http://yourdomain.com/en/<span class="bold">component/com_virtuemart</span>/smaller-shovel-detail.html'</p> 
	you will be able to get links more SEF friendly 
	<p style="font-style:italic">'http://yourdomain.com/en/<span class="bold">shop</span>/smaller-shovel-detail.html'</p>
	<span class="bold">Note that if on your site you will have installed a 3PD advanced extension to manage URL rewriting such as sh404Sef you don't need this setting.</span>
	
	<br/>
	<span class="bold">HEADS UP!</span> 
	For <span class="bold">menu data source</span> you will get a multiselect that you can use to <span class="bold">exclude menu items</span> from your sitemap.<br/>
	For <span class="bold">content data source</span> instead a multiselect will be available to <span class="bold">exclude some categories of contents</span> from your sitemap.
</div>