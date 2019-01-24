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

#### add:ingredient {i_name} {i_amount}
---

Az i_name argumentumban megnevezett hozzávalóból az i_amount-ban meghatározott mennyiséget helyezi a tárolóba (kivéve, ha az összeg meghaladná az 1000 egységet) 

#### add:recipe {name?}
---

A name argumentumban megadott néven (ha nincs megadva, akkor rákérdez a felhasználótól) létrehoz egy új receptet, vagy ha már van ilyen az adatbázisban akkor azt módosítja. Addig fog egymás után bekérni hozzávalónév-mennyiség párokat, amíg a 'done' szót írja be a felhasználó.

#### delete:recipe {name?}
---

Törli a name argumentumban megadott receptet (ha nincs megadva, rákérdez).

#### list:recipes
---

Az adatbázisban található összes receptet kilistázza

#### list:sales
---

A legutóbbi feltöltés óta történt eladásokat és az elfogyasztott alapanyagok mennyiségeit kilistázza.

#### maintenance:off
---

Kikapcsolja a karbantartási üzemmódot. Lényegében csak meghívja az artisan 'up' parancsát. Önmagában redundáns, csak azért lett létrehozva, hogy az app újraaktiválásakor automatikusan lehessen parancsokat lefuttatni.

#### maintenance:off
---

Kikapcsolja a karbantartási üzemmódot. Lényegében csak meghívja az artisan 'down' parancsát, és a 'list:sales' parancsot

#### make:drink {name?}
---

Elkészíti a name-ben megnevezett italt (ha nincs megadva rákérdez), és az adatbázisból kiveszi a szükséges alapanyagokat.

#### refill:all
---

Az összes alapanyagtárólót feltölti a maximum kapacitásáig (1000 egység).

#### refill:ingredient {name?}
---

A name-ben megadott alapanyagot (ha nincs megadva, rákérdez) feltölti a maximum kapacitásáig (1000 egység).





