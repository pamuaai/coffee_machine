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

### Vasárnap (2019.01.20)

A feladatnak vasárnap kezdtem neki, sajnos ami kevés időt aznap rá tudtam fordítani az a fejlesztési környezet előkészítésével telt (szerver telepítése, PHP frissítése, composer, laravel, git telepítése). Ezután létrehoztam magát a projektet, és a git repot.

Erre 1-2 órát tudtam, bár így sem voltam végig a gép mellett amíg telepített.

### Hétfő (2019.01.21)

A tényleges kódolást hétfő este kezdtem. Elsőként létrehoztam az adatbázist, és az első migrációt, ami az 'ingredients' táblát hozza létre. Ez tartalmazza az italokhoz használt hozzávalókat és mennyiségeiket.  
Miután az első adatbázistábla készen állt, valahogy fel szerettem volna tölteni adatokkal, ezért létrehoztam az add:ingredient artisan parancsot. Ez Eloquent ORM segítségével updateli az adott hozzávaló sorát, vagy új sort ad hozzá a táblához ha még nem szerepelne benne.  

Körülbelül este 7-től 10-ig dolgoztam rajta.

### Kedd (2019.01.22)

Már magabiztosabban folytattam, a parancsok nagyrészét kedden implementáltam. Az első nagyobb kihívás volt a receptek tárolásának módja, tekintve hogy bármikor szükség lehet egy új hozzávalóra. Végül amellett döntöttem, hogy egy adatbázistáblában tárolom őket, hogy Eloquent segítségével könnyen kezelhetőek legyenek. A tábla tartalmazza az ital nevét, a szokásos id, created_at és updated_at oszlopokat, és utána határozatlan számú hozzávaló oszlopot, amelyek celláiban a szükséges mennyiség szerepel, így ha recept hozzáadásakor új fajta hozzávalót adna meg a user, annak egy új oszlop jön létre.  

Ezután néhány egyszerűbb parancsot hoztam létre, list:recipes, refill:all, delete:recipe.
Itt következik a kávégép fő funkciója: az italkészítés. A make:drink parancs egy italnevet vár argumentumként(ha nincs megadva, rákérdez. A list:recipes segítségével megtudhatjuk hogy mik az opciók). Először leellenőrzi hogy egyáltalán létezik-e a recept majd ha igen, megnézi hogy áll-e rendelkezésre elegendő alapanyag a gépben. Csak ezek után veszi ki a tárolókból az hozzávalókat, majd kiírja hogy milyen italt készített.  

Azzal zártam a napot, hogy az add:ingredient parancsba beépítettem egy 1000 egységes limitet.

Megint este 7 körül kezdtem a munkát és 11-ig dolgoztam rajta.

### Szerda (2019.01.23)

Erre a napra a list:sales parancs jutott, ehhez előbb a loggolást kellett megoldanom. A Laravel saját Log facade-ja helyett egy újabb adatbázistábla mellett döntöttem, egy egyszerűbb lekérdezések érdekében. Így a legutolsó feltöltés időpontja utáni eladások egyetlen lekérdezéssel kinyerhetők voltak, ezek után csak receptenként összegezni kellett, majd a recept hozzávalóit megszorozni az eladások számával.  
Végül implementáltam a karbantartási módra való korlátozásokat is ahol szükséges.

Este 8-kor jutottam csak számítógép elé, és 11-ig dolgoztam a feladaton.

### Csütörtök (2019.01.24)

A karbantartási mód eddig az alapértelmezett artisan 'up' és 'down' parancsokkal működött. Annak érdekében hogy a fogyasztást automatikusan listázza a karbantartási üzemmód aktiválásakor, létrehoztam a maintenance:on parancsot, ami programatikusan kiadja a 'down' és a 'list:sales' parancsokat. Pusztán a konzisztencia kedvéért létrehoztam a maintenance:off parancsot is, ami az 'up' parancsot adja ki.
Ezután hoztam létre a refill:ingredient parancsot, ami az add:ingredient-tel ellentétben nem vár mennyiséget, csak 1000-re állítja az argumentumban megadott hozzávaló mennyiségét.
Végül a tesztelést megkönnyítendp létrehoztam néhány seedert az adatbázishoz, amik az alapvető hozzávalókat (kávé, tej, cukor) hozzáadják a tárolóhoz (a víz mennyiségét nem szükséges tárolni), és három receptet is hozzáadnak az adatbázishoz (espresso, latte, cappucino)

Ez volt az utolsó nap amikor tudtam dolgozni a projekten. Este 8 körül kezdtem, majd 10-ig folytattam a munkát, és második feladatra így már sajnos nem jutott időm.


## Használat
---

A projekt adatbázist igényel a működéshez. Ezt a .env file-ban kell beállítani a gyökérkönyvtárban.  
Ha megvan az adatbáziskapcsolat, ki kell adni a 'php artisan migrate' és 'php artisan db:seed' parancsokat, hogy alapvető adatokkal feltöltött teszt adatbázisunk legyen. Ezt követően tesztelhetőek a parancsok.
