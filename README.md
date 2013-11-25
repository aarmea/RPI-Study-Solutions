RPI-Study-Solutions
===================

Real, Practical, and Informative Study Solutions, or RPI Study Solutions, is a
website application that will benefit RPI and its students and professors.
Students will be able to search for and form study groups. RPI will be able to
more efficiently use underutilized classrooms. RPI professors will have more
motivated students. We will host tools to help them set up meeting times and
locations. Students will need to login to their accounts in order to form or be
accepted into a group. We will also create a forum/moderator tool to help th e
groups make decisions about projects and share ideas. This will be the main
functionality of the website, but we have many ideas to add to it depending on
how much we can get done within our time limit. We believe that this website
will help college students who desire to study in groups or need to organize
group projects.

Testing locally
---------------

The repository contains a Vagrant configuration for a server virtual machine
that can run locally within your computer running Windows, Mac OS X, or Linux.
To use it, download and install [VirtualBox][virtualbox] and
[Vagrant][vagrant], then in a terminal `cd` to this repository and run
`vagrant up`. Once Vagrant finishes starting the virtual machine, add

    127.0.0.1 www.dev-site.com dev-site.com dev.dev-site-static.com

to your `hosts` file, open a Web browser and navigate to
<http://www.dev-site.com:8080/>. When you're done, run
`vagrant suspend` to stop the virtual machine.

The Vagrant configuration is based on the LAMP stack at
<https://github.com/ymainier/vagrant-lamp> and includes
[PHP Composer][composer] using components from
[vagrant-chef-composer][chef-composer].

[virtualbox]: https://www.virtualbox.org/
[vagrant]: http://www.vagrantup.com/
[composer]: http://getcomposer.org/
[chef-composer]: https://github.com/Version2beta/vagrant-chef-composer
