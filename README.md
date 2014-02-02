# Clean Architecture Demo

inspired by [Robert C. Martin's (Uncle Bob)][1] Talks about clean architecture.
http://vimeo.com/68215570

I also get inspired by a blog post of [Benjamin Eberlei][2]. 
http://www.whitewashing.de/2012/08/13/oop_business_applications_entity_boundary_interactor.html)

When you look at the file structure, you should know what this application is about. If you don't please send me an email and tell why not. Maybe i can do it a better way.

In this application i also tried to use to follow the rules of Robert C. Martin's Book "Clean Code". In my opinion he is totally right.

#Short Explanation of this Architecture

The basic principle is to decouple the business and application
logic from delivery mechanisms and of course decoupling from any
frameworks.

To execute a use case (*Interactor*), you need to create a
**RequestModel** (*App/Common/Request/Request Interface*) and after
finishing business logic, the interactor returns a **ResponseModel**
(*App/Common/Response/Response*) that you can use.

Uncle Bob and Benjamin Eberlei talks/wrote about boundaries. These
are object between delivery mechanism and application. The use case
is to transform request to a RequestModel and a ResponseModel to an
Object the UI can unterstand. Currently i don't implemented it but i
will think about a way to implement that it become useful.

The console application receive the original Response Model and use
it directly. Maybe a good use case is to save Models to the database
as Benjamin Eberlei wrote in his Post.


  [1]: https://sites.google.com/site/unclebobconsultingllc/
  [2]: http://www.beberlei.de/