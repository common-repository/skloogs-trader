=== Skloogs Trader ===
Contributors: skloogs
Donate link: http://tec.skloogs.com/dev/plugins
Tags: trading, bolsa, bovespa, trader, stocks, stock exchange, quotes
Requires at least: 2.7
Tested up to: 2.7
Stable tag: 1.1.1b

This wordpress plugin allows the display of shares from the Bovespa (Brazilian Stock Exchange) and
other Stock Exchanges.

== Description ==

_IMPORTANT_
Development stopped. No more support offered. Thanks. O Author.

This wordpress plugin allows the display of shares from the Bovespa (Brazilian Stock Exchange) and
other Stock Exchanges, within your posts, comments, or any part of your blog,
by using a dedicated markup: `[sktrade]`.

Starting with version 0.4, the plugin can show intraday dynamic quotes from the Bovespa and/or static
quotes from the Bovespa or from other markets, over various periods of time.

The frame's characteristics can be customized by editing a CSS stylesheet, which will be integrated
into the admin panel in a future version.

The applet options can be customized using new options, as explained in the [usage section](./other_notes).

The static charts also provide some options.

See [SYNTAX](.other_notes) section for more information. 

== Installation ==

1. Copy the `skloogs-trader` directory into directory `/wp-content/plugins/`;
1. Ativate the plugin within the 'Plugins' menu in WordPress;
1. Use `[sktrade sharelist]` in your templates and/or posts: see Syntax.

== Syntax and currently supported options ==

The plugin syntax is quite basic. Use `[sktrade <sharelist>]` at the right place
you want to see the charts. The sharelist is a comma separated list of shares,
and possible options. The options are
separated from the share name by an `=` character and from one another by the `|`
character. Additionally, an option can take an argument after the `:` character.

The options are as follows:

* s -> small size (100x200) instead of standard one (180x400) for the applet
* w -> applet width (e.g.: w:300)
* h -> applet height (e.g.: w:150)
* bg -> applet background color, as 3 decimal (0-255) colon (`:`) separated numbers. (e.g.: bg:230:230:230)
* tx -> applet text color, same syntax as bg
* fi -> applet chart fill color, same syntax as bg
* bd -> applet border color, same syntax as bg

Static charts only options:

* p -> period: i,m,2m,3m,6m,y,2y,3y,5y (intraday, 1-2-3-6 months, 1-2-3-5 years)
* v -> show volume on static chart (default)
* nv -> no volume on static chart
* q -> force static chart (default is intraday applet)
* mk -> stock exchange (market): BOV (Bovespa), EURO (Euronext), etc... Check the markets
on the [ADVFN Mundial Summary](http://br.advfn.com/p.php?pid=countrysum)

So if I want a ITAU4 share with special width and bg colors, this would be the syntax:
`[sktrade itau4=w:200|bg:20:20:20]`

Now I'd like to get ITAU4 for the last month and UBBR11 for the last year, with some parameters:
`[sktrade itau4=q|p:m|w:300|txt:200:0:0|bg:255:255:255,ubbr11=s|q|p:y]`

Be careful not to mistakenly switch between options (`|`) and shares (`,`) separators!!
For more clarity, it's authorized to put a space instead of or in addition to the comma.
e.g.: [sktrade itau4=s, ubbr11, petr4]

Regarding foreign exchanges, you won't be able to have the dynamic graph so far, so please do use the
`q` option; in the case you want an intraday graph, also use the `p=i` option.
E.g.: `[sktrade satyamcomp=mk:NSE|q|p=i]` (A big thanks to [Salman Siddiqui](http://bellthebull.com) for the note!)

If you get a frame with just the plugin's copyright, you probably did it wrong...

As a final note, please remember that only the tag is written to the DB, the presentation is made
at the time the page is displayed. So you'll always be able to re-edit your page/post to change
the options.

== Support ==

To get support on the installation and/or use of this plugin, please comment on the
<a href="http://tec.skloogs.com/dev/plugins/skloogs-trader">plugin page</a>. Do not send
an email, because your problem can be someone else's problem too, and I cannot afford
answering each one personally, except in the comments section of the plugin page. Thanks!

== Frequently Asked Questions ==

= How could I show a daily/weekly/monthly chart instead of intraday? =

Just use the `p` (period) and `q` (static quotes) options, as explained in the Syntax section.
Differently from the intraday chart, the static charts don't use an applet and for this reason are...
static... :)

= Is there any way to choose the size of the applet? =

Now there is! Just use the `w` (width) and `h` (height) options, along with the share name.
e.g.: itau4=w:300|h:200 

= Any way to change the frame's background color, border, etc...? =

Just edit the style.css file in the plugin's directory. The CSS file allows to define
anything except the applet apperance.

To change the applet's colors, use the `bg`, `tx`,
`bd` and `fi` options within the `sktrade` tag.

The static charts's colors cannot be changed yet. 

= May I remove your copyright from the plugin output? =

You may. And I may not support your requests for support and/or suggestions regarding future
versions too... it doesn't cost you much to leave it, and it helps with the plugin's promotion.

= Am I legally allowed to show these charts on my blog? =

To my knowledge, nothing prevents you from doing it, since the own applet or static charts do
not implement any access limitation from blogs and do not show any regarding restriction.

= Where do the data in the graphics come from? =

The applet charts come directly from the [Bovespa](http://www.bovespa.com.br) itself. The static charts come from the [ADVFN](http://br.advfn.com) site.

My plugin do not interfere with anything that is shown inside the graphical charts themselves.

= Do you plan to have a Blogger version of this plugin? =

Well, sincerely I doubt... At this exact moment, I don't make any idea how Blogger's plugins work,
and I don't use them for my blog, so... Sometime in the future, maybe?

= Is the configuration menu in the admin section really working? =

Well, no. Not yet. But I'll be working on it as soon as possible, to allow you to configure
a few defaults for the plugin, like aspects and usual market (for people outside brazil)

= What do you earn with this? =

Fame...? Well, if you want to donate, there is a button on my blog too... Don't hesitate! :) 
 
== Screenshots ==

1. Normal size quote (180x400)
2. Small size quote (100x200)
3. Multiple quotes in both sizes

== About the author ==

Philippe Hilger is French, speaking fluently portuguese and english, and has been living in Rio de Janeiro, Brazil, since 2002, and use to trade
on the Bovespa (São Paulo Stock Exchange). He's a Systems, Networks and Security Engineer, developping
programs and utilities during his free time and trying to make some money with it... After running his
own e-commerce company, which unfortunately wasn't the expected success, he's also looking for a job,
in Brazil, in Canada, or in the United States. Feel free to contact him: philippe(DOT)hilger(AROBA)gmail(DOT)com

If you like this plugin, and would like to help making it much better - and there is much to do! - why
not consider making a small donation...?

== ChangeLog ==

* 1.1.1: applet display correction. 
* 1.1: admin menu moveable between own section or settings section
* 1.0: admin menu
* 0.4.4: using new version numbering.
* 0.4c: package 0.4b was screwed... if installed, remove the directory and install version 0.4c
* 0.4b: Standardized main script name (conforming to WP doc)
* 0.4a: Esthetic version. Updated readme. Forget about 0.4. What's next?
* 0.4: added static charts and different periods, from ADVFN. 
* 0.3a: corrected a minor bug that prevent the use of the plugin stylesheet.
* 0.3: included more options to customize the Java applet.
* 0.2: added small charts ability (s option) - Unpublished.
* 0.1: first version of the plugin - Unpublished.