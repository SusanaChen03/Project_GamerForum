# Api Gamer Forum

![Logo](ruta)
# Table of Contents
- [Laravel Gamer Forum](#laravel-Gamer-Forum) 
- [Tabla de contenido](#tabla-de-contenido) 
- [Introducción](#Introducción) 
- [Stack tecnológico 🛠](#stack-tecnológico-) 
- [Descripción 🛠](#Descripción-) 
- [Tablas 🗄](#tables-) 
- [Relaciones 🪢](#relaciones-) 
- [Endpoints 📋](#endpoints-) 
- [Instalación ⚙️](#Instalación-️) 
- [Autor](#autor)
- [Como ayudar](#como-ayudar)
- [Agradecimientos 👏](#agradecimientos-)


## Introducción 
Este proyecto fue impartido por GeeksHubs Academy como parte del FullStack Developer Bootcamp, que consiste en crear una API RESTful para una aplicación tipo Discord usando Laravel y JsonWebTokens.

## Stack tecnológico 🛠

<p align="left">
    <a href="https://laravel.com/" target="_blank" rel="noreferrer"> 
        <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/laravel/laravel-plain-wordmark.svg" alt="Laravel Logo" width="40" height="40"/> 
    </a> 
    <a href="https://www.php.net" target="_blank" rel="noreferrer"> 
        <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/php/php-original.svg" alt="PHP Logo" width="40" height="40"/> 
    </a> 
    <a href="https://www.mysql.com/" target="_blank" rel="noreferrer"> 
        <img src="https://raw.githubusercontent.com/github/explore/80688e429a7d4ef2fca1e82350fe8e3517d3494d/topics/mysql/mysql.png" alt="MySQL Logo" width="40" height="40"> 
    </a> 
    <a href="https://git-scm.com/" target="_blank" rel="noreferrer">
        <img src="https://www.vectorlogo.zone/logos/git-scm/git-scm-icon.svg" alt="Git Logo" width="40" height="40"/>
    </a> 
    <a href="https://heroku.com" target="_blank" rel="noreferrer"> 
        <img src="https://www.vectorlogo.zone/logos/heroku/heroku-icon.svg" alt="Heroku Logo" width="40" height="40"/> 
    </a>
    <a href="https://postman.com" target="_blank" rel="noreferrer"> 
        <img src="https://www.vectorlogo.zone/logos/getpostman/getpostman-icon.svg" alt="Postman Logo" width="40" height="40"/> 
    </a>
    <a href="https://trello.com" target="_blank" rel="noreferrer"> 
        <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/trello/trello-plain-wordmark.svg" alt="Trello Logo" width="40" height="40"/> 
    </a>
</p>

# Descripción 📋

Proyecto del bootcamp en GeeksHubs dónde desde producción nos piden que realicemos el backend de una web app dónde los usuarios pueden crear salas de los videojuegos con el fin de chatear con otros jugadores que quieran jugar, unirse a otras salas ya creadas, escribir mensajes...
Tenemos una rama `master` donde es la rama principal, de allí sacamos ramas con cada tabla para crear la usabilidad y el CRUD en cada una de ellas, como serían `users` `games` `channels` `messages` mergeando a la master una vez acabadas.

A continuación cito los objetivos MVP del proyecto:
 - Los usuarios se tienen que poder registrar a la aplicación, estableciendo un usuario/contraseña.
 - Los usuarios tienen que autenticarse a la aplicación haciendo login.
 - Los usuarios tienen que poder crear Canales (grupos) para un determinado juego.
 - Los usuarios tienen que poder buscar canales seleccionando un juego.
 - Los usuarios pueden entrar y salir de un canal.
 - Los usuarios tienen que poder enviar mensajes al canal. Estos mensajes tienen que poder ser editados y borrados por su usuario creador.
 - Los mensajes que existan en un canal se tienen que visualizar como un chat común.
 - Los usuarios pueden introducir y modificar sus datos de perfil, por ejemplo, su usuario de Steam.
 - Los usuarios tienen que poder hacer logout de la aplicación web.

# Tablas 🗄
 Así sería las relaciones entre las tablas:
 ![tablas_gamerForum.PNG](./app/images/tablas_gamerForum.PNG)
 


Cómo podéis observar he realizado 4 entidades referenciadas como User, Game, Channel y Message, más la tabla intermedia entre User y Channel.
- Tabla `User`:  
Contiene los datos necesarios de los jugadores para registrarse en el sistema, que está relacionada con Channel y Messages.

- Tabla `Game`:
Esta tabla es muy sencilla ya que solo contiene el nombre del juego al que se realiza la búsqueda de canales.

- Tabla `Channel`:
Contiene la información sobre las salas o "Channels", que es dónde se desarrolla la parte más importante, dónde los usuarios pueden unirse o dejar el canal, escribir, editar y borrar mensajes, y visualizar los mensajes de otros usuarios que esten unidos a la misma. 

- Tabla `Messages`:
Esta tabla contiene los mensajes que crean los usuarios, contiene la clave foránea de User y de Channel, solo se pueden crear y visualizar mensajes los usuarios que estén unidos a esa party.

- Tabla intermedia `Channel_User`:
Esta es la tabla intermedia que se genera con la relacion de muchos a muchos, dentro de esta se encuentran la clave forénea de esas dos.


# Relaciones 🪢

Las relaciones entre las tablas son las siguientes:

```
- User vs Game  1:N
- Channel vs Game  1:N
- User vs Channel N:M
- User vs Message 1:N
- Channel vs Message 1:N 
```

# Endpoints ⛩

## Users

* Post('/user', [UserController::class, 'createNewUser']); // Crea un nuevo usuario. 
* Get('/user/{id}', [UserController::class, 'getUserById']);  // Devuelve un usuario buscando por el Id.  
* Get('/users', [UserController::class, 'getAllUsers']);  // Devuelve todos los usuarios.  
* Patch('/user/{id}', [UserController::class, 'updateUserById']);  // Edita el usuario buscándolo por el Id.   
* Delete('/user/{id}', [UserController::class, 'deleteUserById']);  // Borra el usuario.

```json
{
      "name": "userName",
      "email": "userEmail@userDomain.com",
      "password": "userPassword",
      "steamName": "userName of Steam"
} 
```

* Post('/register', [AuthController::class, 'registerUser']);   // Registro de nuevo usuario, creando un token de acceso.
``` json
{ 
    "name":"userName",
    "email": "userEmail@userDomain.com",
    "password": "userPassword",
    "streamName": "userName of Steam"
}
```

* Post('/login', [AuthController::class, 'loginUser']);  // Logeo de un usuario, creando un token de acceso.
``` json
{ 
  "email": "userEmail@userDomain.com",
  "password": "userPassword",
}
```

* Post('/logout', [AuthController::class, 'logoutUser']);  // Logout del usuario, pasando el token por el body.
``` json
{ 
  "token": "token generated",
}
```
* Get('/profile', [AuthController::class, 'getMyProfile']); // Devuelve los datos del usuario logeado


## Game

 * Post('/game', [GameController::class, 'createGame']);  // Con el Id logeado el usuario crea un juego
    Route::get('/games', [GameController::class, 'getAllGames']);  // Devuelve todos los juegos creados por el usuario.
* Get('/game/{id}', [GameController::class, 'getGameById']);  // Busca el juego por el id indicado por parametro.
* Patch('/game/{id}', [GameController::class, 'updateGameById']);  // Buscar el juego por su id y puede editar el nombre del juego.
* Delete('/game/{id}', [GameController::class, 'deleteGame']);  // Borra el id encontrándolo por su id.

``` json
{
    "name": "The JS game"
}
```

## Channel

* Post('/channel', [ChannelController::class, 'createChannel']);  //  Con el usuario logeado crea un nuevo canal de conversación.
* Get('/channel/{id}', [channelController::class, 'getChannelById']);  // Devuelve el canal buscándolo por el id.
* Get('/channels', [channelController::class, 'getAllChannels']);  // Devuelve todos los canales de ese usuario.
* Patch('/channel/{id}', [channelController::class, 'updateChannel']);  // Busca el canal por el id del canal y se edita el nombre del canal.
* Delete('/channel/{id}', [channelController::class, 'deleteChannel']);  // Borra el canal creado con sus mensajes.

``` json
{
    "name": "GameName",
    "game_id": "game_id"
}
```

## Channel_User

* Post('/channelByUser', [channelController::class, 'createChannelByUserId']);  // Crea la relación del usuario con el canal.
* Get('/getChannelByUser', [channelController::class, 'getChannelByUserId']);  // Devuelve el canal que creó el usuario.
* Post('/letChannelByUser', [channelController::class, 'letChannelByUserId']);  //Borra la relación que hay entre el usuario y el canal.

``` json
{
    "iduser":"user_id",
    "idchannel": "channel_id
}
```
## Messages

* Post('/message/{id}', [MessageController::class, 'createMessage']);   //Crea un mensaje en el canal con el id indicado.
* Get('/message/{id}', [MessageController::class, 'getMessageById']);  // Busca el mensaje escrito por el id del mensaje.
* Get('/messages', [MessageController::class, 'getAllMessages']);  // Devuelve todos los mensajes escritos por el usuario.
* Patch('/message/{id}', [MessageController::class, 'updateMessageById']);  // Edita los mensajes buscándolos por el id de mensaje.
* Delete('/message/{id}', [MessageController::class, 'deletedMessage']);  // Borra un mensaje publicado por su id.

``` json
{
    "message": "the message"
}
```

# Instalación 🥷

Para poder consumir la api es necesario lo siguiente:
- Clonar o forkear el repositorio si deseas, **Susana:** _(https://github.com/SusanaChen03/Project_GamerForum)_.
- Instalar Composer: `https://getcomposer.org/download/`
- Hacer _composer install_ para cargar las dependencias del composer.json
- Atacar al API publicada en https://gamer-forum.herokuapp.com/ o como localhost si lo prefieres (es necesario cambiarlo en el .env)
- Revisar esta documentación.
- Es necesario utilizar Postman para probar el Api ya que carece de Frontend.
- Conexión a internet

# Autor 🤟

Alumna de Geekshubs: Susana Chen.

# Como ayudar 🤝

  - Si deseas colaborar con éste proyecto u otro no dudes en contactar conmigo o solicitar una pull request.
  - Mi correo electrónico _grupochen@hotmail.com_
  - Cualquier aporte se puede recompensar con una cerveza, a no ser que no quieran cerveza se cambiaría a café.


# Agradecimientos 💖

  * A nuestro profesor Dani Tarazona, por su paciencia y su dedicación, con un método de enseñanza excepcional.
  * Repositorio público con código libre con el fin de seguir promoviendo compartir conocimientos y ayudar a otros programadores.
