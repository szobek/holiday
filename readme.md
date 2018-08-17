
# Szabadság nyilvántartó

Ez a szabadság nyilvántartó

## funkciók

* felhasználó regisztráció
    + név
    + email
    + stb
    + több cég
    + szabadságainak száma
    
* Szabadság nyilvántartása Google Calendarban
    + crud
    + keresés
    + számlálás éves szinten a profil megtekintésekor

* cégek 
    + Teljes név
    + Rövid név
    + cím
    + adószám
    + Dolgozók ebben a cégben

* Jelenléti 
    + nyomtatás előre definiált formában
    + checkIn oldal az érkezés/távozás regisztrálás miatt
    + Ünnepnapok felvitele
    + ledolgozós napok felvitele
    
* Jogosultsági rendszer
    + szétbontva metódusokra azaz funkciókra

* Üzenetek
    + új üzenet/beszélgetés
    + válasz üzenetre
    + üzenet lista frissítés 5s-ként
    + üzenet küldés:  ctrl+enter
    
    

    
## Telepítés
```

composer install

```

```
create .env file
fill .env with data ->

APP_NAME={appName}
APP_ENV=local
APP_KEY=base64:........
APP_DEBUG=false
APP_LOG_LEVEL=debug
APP_URL=http://localhost:8201
TIME_ZONE=Europe/Budapest

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE={dbName}
DB_USERNAME={userName}
DB_PASSWORD={password}


GOOGLE_CALENDAR_ID={key}@group.calendar.google.com
GOOGLE_CALENDAR_EMBED=https://calendar.google.com/calendar/embed?src=********%40group.calendar.google.com&ctz=Europe%2FBudapest

BROADCAST_DRIVER=log
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync
```

```
php artisan key:generate
```

```

/**
 * bool {dev}
 * development seeder run for test data
 */ 
php artisan build:db {dev}
  
```

```
google json save to
storage\app\google-calendar\service-account-credentials.json

```