Bienvenido al README de Concesionarios Manzano esta pagina web trata de una compra venta de coches en el mismo sitio web teniendo dos apartados 
distintos para si los coches son del usuario o del concesionario, si estos pertenecen al concesionario seran km0.


Para empezar habra 3 jerarquias en nuestra pagina:
**No logueado**:Este **no podra ver opciones exclusivas** para logueados.

**Logueado**:podra acceder a las **opciones exclusivas** mencionadas.

**Admin**:podra acceder a todas las **opciones exclusivas** ademas de a **un panel de admin** que comentaremos despues.


Funciones para **no logueados**:

Los no logueados simplemente podran moverse por la web viendo los distintos coches diferentes que hay pudiendo contactar con sus respectivos dueños (si
son km0 con la empresa) y subir su curriculum si esta interesado en trabajar con nosotros ademas podran calcular su financiacion.

Funciones para **Logueados**:

Los logueados podrán acceder a un comparador de coches tambien a subir su coche a la pagina para ponerlo a la venta ademas podran marcar sus coches favoritos para 
poder verlos aislados en otra seccion de la pagina tambien podras contactar con nosotros si estas registrado.

Funciones del **Admin**:

El admin podra acceder a lo antes mencionado ademas de poder acceder a un panel donde podra subir coches al concesionario de manera muy simple asi como aliminarlos o editarlos
tambien podra eliminar y editar usuarios que esten registrados en la pagina ver los mensajes que han mandado desde el formulario de contacto y podra eliminarlos ademas podra poner notas como si fuese un post-it para los demas de mantenimiento que lleven la pagina.

Mi Pagina Suponiendo que estas **logueado** tiene todas estas **secciones**:

**index.php**:El inicio de la pagina, este tendra un nav para dirigirte a los otros lugares de la pagina y tiene un enlace y una breve descripcion de cada una de las secciones.

**vehiculos.php**:Esta es la seccion donde se mostraran los vehiculos km0 de la pagina estos solo los podra subir el admin desde su panel,en esta seccion podremos directamente habla con la empresa por nuestro wathsApp business o contactarnos por la pagina para que respondamos a tu peticion desde el panel de admin, ademas podras agregar los coches que te gusten a favoritos.

**vehiculosUsuarios.php**:seccion casi identica a la de vehiculos km0 donde se muestran los coches que suben los usuarios logueados a la pagina desde la seccion sube tu coche ,en la carta de cada vehiculo muestra sus datos y una opcion para poder hablar por whatsApp con el usuario que lo haya subido ademas de la opcion de agregar a favoritos y nuestro whatsApp de empresa por si es necesario preguntarnos algo.

**subeTuCoche.php**:En esta seccion esta el formulario para subir tu coche a la seccion vehiculosUsuarios.php.

**financiacion.php**:En esta seccion propondremos los planes de financiacion del concesionario y tenemos una opcion en la que mediante un formulario hacemos una cuenta para que nos devuelva el dinero que tendriamos que dar por mes a causa de la financiacion para ver si nos renta tomarla o no.

**nosotros.php**:Aqui es donde mostramos un poco mas de quienes somos y mostramos un poco nuestro equipo de trabajo y nuestras instalaciones.

**trabajaConNosotros.php**:Aqui dejamos un formulario para que entreguen su curriculum y formar parte de el equipo de nuestro concesionario .

**comparator.php**:Aqui muestro todos los coches del concesionario,da igual si son km0 o no,y doy la oportunidad de arrastrar el coche que te interese y compararlo con otro que te ha llamado la atencion para mostrar cual tiene las caracteristicas mas rentables.

**favoritos.php**:seccion donde muestro los coches favaritos de mi pagina segun el usuario.

**contacto.php**:seccion donde tenemos en formulario de contacto para los logueados ademas de nuestra ubicacion en un mapa y la posibilidad de pinchar un enlace y nos hables por whatsApp para darte las respuestas que buscas.

**politicaPrivacidad.php**:politica de privacidad de nuestra pagina.

**politicaCookies.php**:politica de cookies de nuestra pagina.

**install.php**:En el install tendremos todas las tablas de la base de datos de la pagina asique tendremos que instalarlo antes de usar la pagina. 

**config.php**:Aqui tendremos la configuracion de acceso para acceder a nuestra base de datos 

**login.php**:formulario de login.

**registro.php**:formulario de registro

**logout.php**:cerrar sesion.

**adminDashboard.php**:Aqui es desde donde el admin con su cuenta se podra meter y gestionar toda la pagina para ello son los archivos de agregar...php ,eliminar...php ,procesarEdicion...php ,sirven para que podamos eliminar editar o agregar archivos a nuestra base de datos haciendo que se modifique nuestra pagina y de una manera muy visual y simple que podras ver luego si sales del panel de admin desde hay podras gestionar todos los usuarios,curriculum,mensajes y coches de la pagina sin tener ni idea de programar.