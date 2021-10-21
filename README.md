# PROYECTO PHP


### CONCEPTOS GENERALES

El proyecto se basa en la creación de un sitio web de la Comunidad de Madrid que proporciona fecha de vacunación del Covid-19 a un usuario haciendo uso de diversas tecnologías o procedimientos, como acceso a bases de datos o la incorporación de sesiones y cookies, entre otras cosas.  
Dicho sitio se compone por una página o index principal y diversas más conectadas entre sí, teniendo en cuenta que cada una de ellas ofrece un servicio distinto, pero todas comparten cabecera y pie de página. También contamos con una base de datos a la que acceden algunas de estas páginas.  
Desde el index podemos crearnos un usuario y darnos de alta en el sistema rellenando un formulario o bien iniciar sesión mediante dirección de correo electrónico con una cuenta previamente creada.  
Al iniciar sesión se redirige al usuario a una página con toda su información. Dicha página conecta con la base de datos y recupera aquellos campos que son relevantes para el usuario, como sus datos personales y las fechas de vacunación, que son asignadas de forma automática.  
Sin embargo, si iniciamos sesión con un correo determinado (gestor@gmail.com), se nos redirigirá a una página donde podremos gestionar las vacunas del sistema: borrarlas, visualizarlas, editarlas y crearlas. A esta página sólo se permite acceder, una vez logeado, al usuario nombrado unas líneas más arriba.  
Contamos con una página de error personalizada, además de implementar algo de tecnología Ajax en el login y Bootstrap en todas las páginas.