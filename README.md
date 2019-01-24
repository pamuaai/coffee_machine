Coffee Machine - Brightly tesztfeladat
=======

## Első feladat

A következő parancsok állnak rendelkezésre a kávégép használatához:

    *add:ingredient {i_name} {i_amount}
    *add:recipe {name?}
    *delete:recipe  {name?}
    *list:recipes
    *list:sales
    *maintenance:off
    *maintenance:on
    *make:drink {name?}
    *refill:all
    *refill:ingredient {name?}

### add:ingredient {i_name} {i_amount}
---

Az i_name argumentumban megnevezett hozzávalóból az i_amount-ban meghatározott mennyiséget helyezi a tárolóba (kivéve, ha az összeg meghaladná az 1000 egységet) 

### add:recipe {name?}
---

A name argumentumban megadott néven (ha nincs megadva, akkor rákérdez a felhasználótól) létrehoz egy új receptet, vagy ha már van ilyen az adatbázisban akkor azt módosítja. Addig fog egymás után bekérni hozzávalónév-mennyiség párokat, amíg a 'done' szót írja be a felhasználó.

### delete:recipe {name?}
---

Törli a name argumentumban megadott receptet (ha nincs megadva, rákérdez).

### list:recipes
---

Az adatbázisban található összes receptet kilistázza.

### list:sales
---

A legutóbbi feltöltés óta történt eladásokat és az elfogyasztott alapanyagok mennyiségeit kilistázza.

### maintenance:off
---

Kikapcsolja a karbantartási üzemmódot. Lényegében csak meghívja az artisan 'up' parancsát. Önmagában redundáns, csak azért lett létrehozva, hogy az app újraaktiválásakor automatikusan lehessen parancsokat lefuttatni.

### maintenance:off
---

Kikapcsolja a karbantartási üzemmódot. Lényegében csak meghívja az artisan 'down' parancsát, és a 'list:sales' parancsot

### make:drink {name?}
---

Elkészíti a name-ben megnevezett italt (ha nincs megadva rákérdez), és az adatbázisból kiveszi a szükséges alapanyagokat.

### refill:all
---

Az összes alapanyagtárólót feltölti a maximum kapacitásáig (1000 egység).

### refill:ingredient {name?}
---

A name-ben megadott alapanyagot (ha nincs megadva, rákérdez) feltölti a maximum kapacitásáig (1000 egység).

## A munkafolyamat:

### Vasárnap

A feladatnak vasárnap kezdtem neki, sajnos ami kevés időt aznap rá tudtam fordítani az a fejlesztési környezet előkészítésével telt (szerver telepítése, PHP frissítése, composer, laravel, git telepítése).

### Hétfő

A tényleges kódolást hétfő este kezdtem. Elsőként létrehoztam az adatbázist, és az első migrációt, ami az 'ingredients' táblát hozza létre. Ez tartalmazza az italokhoz használt hozzávalókat és mennyiségeiket.  
Miután az első adatbázistábla készen állt, valahogy fel szerettem volna tölteni adatokkal, ezért létrehoztam az add:ingredient artisan parancsot. Ez Eloquent ORM segítségével updateli az adott hozzávaló sorát, vagy új sort ad hozzá a táblához ha még nem szerepelne benne.  

Körülbelül este 7-től 10-ig dolgoztam rajta.

### Kedd

Már magabiztosabban folytattam, a parancsok nagyrészét kedden implementáltam. Az első nagyobb kihívás volt a receptek tárolásának módja, tekintve hogy bármikor szükség lehet egy új hozzávalóra. Végül amellett döntöttem, hogy egy adatbázistáblában tárolom őket, hogy Eloquent segítségével könnyen kezelhetőek legyenek. A tábla tartalmazza az ital nevét, a szokásos id, created_at és updated_at oszlopokat, és utána határozatlan számú hozzávaló oszlopot, amelyek celláiban a szükséges mennyiség szerepel, így ha recept hozzáadásakor új fajta hozzávalót adna meg a user, annak egy új oszlop jön létre.  

Ezután néhány egyszerűbb parancsot hoztam létre, list:recipes, refill:all, delete:recipe.
Itt következik a kávégép fő funkciója: az italkészítés. A make:drink parancs egy italnevet vár argumentumként(ha nincs megadva, rákérdez. A list:recipes segítségével megtudhatjuk hogy mik az opciók). Először leellenőrzi hogy egyáltalán létezik-e a recept majd ha igen, megnézi hogy áll-e rendelkezésre elegendő alapanyag a gépben. Csak ezek után veszi ki a tárolókból az hozzávalókat, majd kiírja hogy milyen italt készített.  

Azzal zártam a napot, hogy az add:ingredient parancsba beépítettem egy 1000 egységes limitet.

Megint este 7 körül kezdtem a munkát és 11-ig dolgoztam rajta.