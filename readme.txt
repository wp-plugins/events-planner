=== Events Planner ===
Contributors: abelony
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=abels122%40gmail%2ecom&lc=US&item_name=Events%20Planner%20for%20Wordpress&no_note=0&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHostedGuest
Tags: events, event, events planner, event planner, event registration, event calendar, events calendar, event management, paypal, registration, ticket, tickets, ticketing, tickets, widget, locations, maps, booking, attendance, attendee, calendar, payment, payments, sports, training, dance
Requires at least: 3.1
Tested up to: 3.2
Stable tag: 1.0

Events Planner: A powerful next generation event management plugin, built with custom post types

== Description ==

[Events Planner](http://www.wpeventsplanner.com/) is a next generation wordpress events management plugin. A lot of research has been done on what features are needed for event management
and what's lacking out there.  Here is a quick overview video, followed by a list of features.

[youtube http://www.youtube.com/watch?v=OLiF2tiadOU /]

Programming:

* All data is stored using existing WordPress architecture (Custom Post Types, options, post and user meta). No new tables are introduced.
* Built using MVC design pattern. Only necessary files are loaded per request, not the whole plugin.
* Can be extended using custom hooks and configurations. Use filters to add fields to any section of the plugin. -Pro
* Coming Soon, with the help of an extender plugin, the ability to modify all the views and styles that come with the plugin.

List of features:

* All the data is stored in Wordpress tables (post, post meta, options...)  **No custom tables are used.**  As such, the plugin is powerful enough to let you add and retrieve any type of information that you would like to associate with the events.
* You can use custom templates and use custom template tags for displaying event details.

Inside each event:

1.  Have unlimited number of days.  You can use the **Recurrence Helper** for previewing and creating the dates.
1.  Create unlimited times
1.  Create unlimited prices/tickets

Completely control each event and:

1.  Allow the user to register for **only one day**.
1.  Allow the user to register for **one or more days**.
1.  Register the user **for all the days in your event**. -Pro
1.  Register the user for a course with multiple days and use the recurrence helper to show a calendar of the course. -Pro
1.  Allow the user to register more than one person.
1.  Create unlimited forms and collect any information that you would like from the ticket buyer (and optionally, from additional attendees).


If the user chooses to register for more than one day:

1.  Allow the user to select **the same time for all the days** 
1.  Allow the user to select **different time for each day that they choose** -Pro
1.  Allow the user to select **the same price for all the days**
1.  Choose if the prices apply to **the whole event or each day**
1.  Allow the user to select **different price for each day that they choose** -Pro
1.  Have time specific pricing -Pro
1.  Control available spaces per day (event, time or price in pro).

Accept Payments

1.  Create unlimited payment profiles.  This means that you can have multiple settings for each gateway.
1.  Inside each event, you can select which account the payment goes to and pick and choose which payment methods the user can use.
1.  Current payment choices: PayPal ExpressCheckout (in the free version). Check, PayPal Pro (Direct Payments), Authorize.net AIM and SIM in the Pro version.  More on the way.

Manage Locations

1.  Create unlimited event locations.  As this is also a custom post type, you can create your own templates and use the custom template tags.

Manage Organizations

1.  Create and manage unlimited organizations and inside each event, select which organization is hosting the event.

Manage Registration Forms

1.  Use the AJAX powered form manager to easily create and use as many forms as you would like.
1.  Inside each form, you can sort the order of the fields.
1.  Inside each event, you can choose which forms to use to collect the registration information from the ticket buyer (and optionally, the other attendees).

Accept and Manage Registrations (**coming very soon**)

1.  All the registration information is stored in a custom post type.
1.  The user will go through a process similar to a shopping cart (i.e. select event > select event options > enter registration info > see overview > pay > done).
1.  Along with the registration data, you will see the payment information inside the post.
1.  You can create new registrations and modify them from inside the Wordpress admin.

Some features being worked on right now

[Please let us know about your needs](http://www.wpeventsplanner.com/contact-us/)

*   Notification manager for creating unlimited notification types and use shortcodes to include information in the email body.
*   Comprehensive Discount manager
*   Various AJAX calendar widgets
*   and some that are a secret for now :)

[Again, please let us know about your needs](http://www.wpeventsplanner.com/contact-us/)

== Installation ==


1. Upload `events-planner` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Create a new page and place `[events_planner]` shortcode in there
1. Go to Events Planner > Settings and make selections
1. Go to Events Planner > Form Manager and create some fields and forms.  By default, the Ticket buyer form configurations are installed.
1. Go to Events Planner > Organizations and create one or more organizations that will be hosting the event.
1. Go to Events Planner > Payment Profiles and create payment profiles.
1. Go to Events Planner > Locations and create locations for the events.
1. Go to Events Planner > Categories and create some event categories.


== Screenshots ==

1. Event Management Page
2. Form Builder
2. Registration Page Overview

== Changelog ==

= 1.0 =

* Hello World

== Upgrade Notice ==

* None

== Frequently Asked Questions ==

Please visit our [Contact Page](http://www.wpeventsplanner.com/contact-us/) and ask us anything about the plugin.

Here are some overview [Videos](http://www.wpeventsplanner.com/video-overview/).
