# Bede Gaming Developer Test
As a way for Bede Gaming to get to know a developers skills, they ask you to do a simple task with some deliverables, please see [brief.md](brief.md)

## Setup
To setup this project, please run the following command in a terminal `composer install && vagrant up`.  
  
This will install all composer dependencies, then start a homestead vagrant box and finish off installation with database migrations etc.
  
You can now login with the following credentials;

- Username: `developers@bedegaming.com`
- Passwrod: `password`

## Tests
At this moment there aren't any, I wish to learn TDD etc. but haven't had a chance to use it in a work environment, and at home I tend to hack more than produce production read code 1st time.

## Why did I use what I did?
This one is simple, as a PHP Developer mainly focused on back end development I chose to use Laravel 5.2 (what I believe to be the best framework at the moment). Yes the project could have been written without one, but for the simplicity of getting things up and running, Laravel was the clear choice for me.  
  
Now for the front end! I am, and never would claim to be, a front end dev. I have some skills in this department, it would be silly not to have in this market. So I could have simply, and fast, made it fully with Laravel, and the beautiful blade templates. However, I have decided to push myself and use [Vuejs](http://vuejs.org/) along with the [Vue Router](http://vuejs.github.io/vue-router/en).  
  
At the time of writing this, the site isn't finished and would never be production ready code (I have taken a few shortcuts, like disabled CSRF etc.). The map shown is local to your geolocation, there are no list of casino's, you can't yet search them, but when you do, there will be a distance from your location based on IP address (again hacky, but it works for this).

