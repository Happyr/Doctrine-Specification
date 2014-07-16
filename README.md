# Happyr Doctrine Specification Bundle

This bundle gives you a new way for writing queries...

This library was created with a lot of inspiration from Benjamin Eberlei's [blog post](whitewashing) and
from my (Tobias Nyholm) discussion with Kacper Gunia on [Sound of Symfony podcast](sos).

Using the [Specification pattern](wiki_spec_pattern)



## The problems

The problems are:

 * Doctrine repository functions get messy
 * Lots of code duplicate
 * It is very hard to test

### Example of bad repos
` Lots of functions `

` Lots of messy code `

`Lots of function arguments`



## The solution

* Re-useable code
* Easy to test
* Easy to extend, store and run

### Example using the library


[whitewashing]:[http://www.whitewashing.de/2013/03/04/doctrine_repositories.html]
[wiki_spec_pattern]:[http://en.wikipedia.org/wiki/Specification_pattern]
[sos]:[http://www.soundofsymfony.com/episode/episode-2/]