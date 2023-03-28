# PL/SQL az 1. ZH-hoz

## Összefoglaló
```sql
SET SERVEROUTPUT ON -- kiiratás engedélyezése
ACCEPT bejovo PROMPT; -- Adatbekérés a felhasználótól

BLOKKNÉV
    DECLARE -- változók, konstansok, függvények, eljárások

    BEGIN -- programkód helye
    adat := '&bejovo'; --eltároljuk a nevet egy változóban, hogy ne kelljen rá &-el hivatkozni
        
    EXCEPTION -- kivételek
	
END BLOKKNÉV;
/ -- per jel zárja le a blokkot!!!!!!
```

## Szintaxis

```sql
BLOKKNÉV
DECLARE
	-- változók, konstansok, függvények, eljárások
BEGIN
	-- programkód
EXCEPTION
	-- kivételek
END BLOKKNÉV;
/ -- per jel zárja le!!!!!!
```

- utasításokat pontosvessző zárja;
  - viszont sok dolog nem utasítás pl a BEGIN után nem kell ;
- kis nagybetű ugyanaz
- egysoros komment. `--` vagy `REM`
  - többsoros `/* szoveg */`
- plsql változók használhatóak sql utasításokban

## kiíratás

```sql
SET SERVEROUTPUT ON -- kiiratás engedélyezése
BEGIN
    DBMS_OUTPUT.PUT_LINE('Hello World!'); -- NAGYAON FONTOS
END;
/
```

## Változó deklarálás

`változónév [CONSTANT] addatípus [NOT NULL] [DEFAULT érték]`

- DEFAULT helyett lehet `:=`

```sql
DECLARE
    szoveg VARCHAR2(50);
    kezd NUMBER := 10;
    egy CONSTANT NUMBER :=1;
```

## Szövegösszefűzés

`DBMS_OUTPUT.PUT_LINE(udvozlo || nev || '!'); -- udvozlo es nev változók, '!' string`

## Szöveg bekérése a felhasználótól

```sql
ACCEPT nev PROMPT 'ird be a neved' -- declare előtt!!!!!!!! NAGYONFONTOS
DECLARE
    nev VARCHAR(20);
BEGIN
    nev := '&nev'; --eltároljuk a nevet egy változóban, hogy ne kelljen rá &-el hivatkozni
```

## rekordipus deklarálás

```sql
TYPE rekordtipusnev IS RECORD (mezonev tipus, ... mezonev ipus); -- rekord tipus létrehozása
változónév rekordtipusnev; -- rekordtipusnev tipusú változó deklarálása
változónév.mezőnév -- hivatkozás a rekord egy mezejére
változonev tabla%RAWTYPE; -- Rekord létrehozása adott táblához (olyan lesz mint a tábla egyetlen sora)
```

```sql
DECLARE
    TYPE dolgozo_rekord IS RECORD (adoszam INTEGER, nev CHAR(30), lakcim VARCHAR2(50));
    egy_dolgozo dolgozo_rekord;
BEGIN
    egy_dolgozo.nev := 'Kovacs';
END;
/
```

- `TO_CHAR` : stringgé konvertál (dátumot pl)
- `TO_DATE` : stringből dátum

## SQL lekérdezés PL/SQL blokkban:

```sql
SELECT oszlop1, oszlop2, ... , oszlopN
    INTO változó1, változó2, ... , változóN --itt tároljuk alekérdezett értékeket
    FROM táblalista; -- Itt csakis egy rekordra szabad kérdezününk rá mert egyébként nem tudná eltárolni
```

`tábla.mező%TYPE` -- tábla adott mezejének típusát kérdezi li

sor típusú változót is deklarálhatunk:
változónév.attribútum módon lehet hivatkozni rá
tábla%RAWTYPE

## feltételes vezérlési szerkezet

```sql
IF feltétel THEN
    -- programkod
ELSIF feltétel THEN -- ez itt nem elírás!! ELSIF nem peig elseif!!!!!!
    -- programkod
ELSE
    --programkod
END IF;
```

```sql
/* Lekérdezi a dolgozók fizetésének átlagát, majd az értéktől függően kiír egy szöveget. */
DECLARE
    v_avgber DEMO.munkatars.ber%TYPE;
    szoveg VARCHAR2(50);
BEGIN
    SELECT AVG(ber)
        INTO v_avgber
        FROM DEMO.munkatars;
    IF v_avgber < 100000 THEN
        szoveg:='kevesebb mint szazezer';
    ELSIF (v_avgber > 100000) AND (v_avgber <= 200000) THEN
        szoveg:='szazezer es ketszazezer kozt';
    ELSE
        szoveg:='ketszazezer folott';
    END IF;
    DBMS_OUTPUT.PUT_LINE(szoveg);
END;
/
```

## gyűjtőtáblák

```sql
TYPE táblatípusnév IS TABLE OF {oszloptípus | rekodtípus } INDEX BY BINARY_INTEGER; -- Létrehozás
```

### A gyűjtáblák használatára gyűjtábla metódusok szolgálnak:

- `EXISTS(n)`: igaz, ha az n-edik index létezik
- `COUNT`: a táblában lévő elemek száma
- `FIRST/LAST`: az első és utolsó elem indexét adja vissza
- `NEXT(n)`: a táblában az n-et követő index értéke
- `DELETE(n)`: törli az n-edik indexen lévő elemet

```sql
DECLARE
    TYPE tipus IS TABLE OF DEMO.vevo%ROWTYPE INDEX BY BINARY_INTEGER;
    valtozo tipus;
    ind BINARY_INTEGER := 1;
BEGIN
    LOOP -- gyűjtőtábla feltöltése
        SELECT * INTO valtozo(ind)
            FROM DEMO.vevo
            WHERE partner_id = 20 + ind;
        ind := ind + 1;
        EXIT WHEN ind > 8;
    END LOOP;

    -- a gyűjtőtáblában tárolt értékek kiíratása
    ind := valtozo.FIRST;
    LOOP
        DBMS_OUTPUT.PUT_LINE(valtozo(ind).megnevezes);
        ind := ind + 1;
        EXIT WHEN ind > valtozo.LAST;
    END LOOP;
END;
/
```

A program egy rekordtípusú gyűjtőtáblába - amely szerkezete megegyezik a DEMO adatbázis
VEVŐ tábláéval - kigyűjti a rekordokat úgy, hogy az index a partner_id lesz.
Ezt követően végigmegy a gyűjtőtábla elemein és kiíratja a megnevezést.

## kivételkezelés beépített kivételekkel

A beépített kivételek közül néhány:

- `DUP_VAL_ON_INDEX`: insert vagy update utasítással unique indexben már meglévő érték beszúrása
- `TEMOUT_ON_RESOURCE`: időtúllépés miközben oracle erőforrásra várakozott
- `NO_DATA_FOUND`: a SELECT utasítás nem adott vissza sort
- `TOO_MANY_ROWS`: egy sort kellett volna visszaadni a SELECT utasításnak, de több sorral tért vissza
- `INVALID_NUMBER`: a karakterláncot nem sikerült számmá konvertálni
- `OTHERS`: az egyéb, az EXCEPTION részben fel nem sorolt kivételek lekezelésére szolgál

A felsoroltakon kívül még sok kivétel van.

Amikor a rendszerben egy kivéltel létrejön, a vezérlés a kivételkezelő szegmensre adódik át és a
végrehajtó szegmens további utasításai nem futnak le.

```SQL
DECLARE
    v_ber DEMO.munkatars.ber%TYPE;
    v_veznev DEMO.munkatars.vezeteknev%TYPE;
    v_kernev DEMO.munkatars.keresztnev%TYPE;
BEGIN
    v_ber := 200000;
    SELECT vezeteknev, keresztnev
        INTO v_veznev, v_kernev
        FROM DEMO.munkatars
        WHERE ber = v_ber;
    DBMS_OUTPUT.PUT_LINE(v_veznev || ' ' || v_kernev);
EXCEPTION
    WHEN NO_DATA_FOUND THEN
        DBMS_OUTPUT.PUT_LINE('Nincs ilyen fizetés');
    WHEN TOO_MANY_ROWS THEN
        DBMS_OUTPUT.PUT_LINE('Több embernek is ez a fizetése');
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('Egyéb hiba');
END;
/
```

A SELECT lekérdezés kigyűjti azoknak a dolgozóknak az adatait, akiknek a fizetése 200.000 Ft.
Ha nincs ilyen dolgozó, akkor egy NO_DATA_FOUND kivétel jön létre. Ha több ilyen dolgozó is van,
akkor TOO_MANY_ROWS kivétel jön létre. Ha pontosan egy ilyen dolgozó van, akkor nem jön létre kivétel.
Minden más kivétel lekezelésére az OTHERS rész szolgál.

## Explicit kurzorok

```sql
CURSOR kurzornév IS lekérdezés;
```

- Az explicit kurzorokat a végrehajtó szegmensben az `OPEN kurzornév;` utasítással nyitjuk meg.
- Az egyes sorokat a `FETCH kurzornév INTO változólista;` utasítással dolgozzuk fel.
- A változólistába annyi változót kell megadni, ahány oszlopot kérdeztünk le a kurzor lekérdezésében
- A feldolgozás végén a kurzort a `CLOSE kurzornév;` utasítással zárjuk le.

```sql
DECLARE
    v_veznev DEMO.munkatars.vezeteknev%TYPE;
    v_kernev DEMO.munkatars.keresztnev%TYPE;
    v_tel DEMO.munkatars.telefon%TYPE;
    CURSOR nev_es_tel IS
        SELECT vezeteknev, keresztnev, telefon
        FROM DEMO.munkatars
        ORDER BY vezeteknev, keresztnev;
BEGIN
    OPEN nev_es_tel;

    LOOP
        FETCH nev_es_tel
            INTO v_veznev, v_kernev, v_tel;
        EXIT WHEN nev_es_tel%NOTFOUND;
        DBMS_OUTPUT.PUT_LINE(v_veznev || ' ' || v_kernev || ': ' || v_tel);
    END LOOP;
    CLOSE nev_es_tel;
END;
/
```

Létrehozunk egy kurzort, amelynek lekérdezésével lekérdezzük a dolgozók adatait.
A végrehajtó szegmensben megnyitjuk a kurzort, ekkor hajtódik végre a lekérdezés,
és egyenként feldolgozzuk a sorokat egy ciklusban. A kiugrási feltételünk a ciklusból az,
ha a NOTFOUND kurzorfüggvény igaz értékkel tér vissza.
Egyébként pedig kiíratjuk a feldolgozott sort.

## ZHHOZ:

### EZEK A TÁBLÁK LESZNEK:

<pre>
Varosok (

irsz NUMBER(5) NOT NULL, -- A város irányítószáma
orszag VARCHAR2(40) NOT NULL, -- A város országa
nev VARCHAR2(30), -- A város neve
folyomentiE NUMBER(1), -- Folyó mentén található-e a város?
varVANe NUMBER(1), -- Vár található-e a városban?
furdoVANe NUMBER(1), -- Fürdő van-e a városban?
PRIMARY KEY(irsz, orszag) -- A Varosok tábla kulcsát az irsz és az ország együtt alkotják

);
A folyomentiE, varVANe és furdoVANe attribútumok esetében az érték nulla, ha nem rendelkezik a város az adott tulajdonsággal, és egy, ha igen.

Egyetemek (

rovidites VARCHAR2(10) PRIMARY KEY NOT NULL, -- Az egyetem rövidítése, és kulcsa
nev VARCHAR2(100), -- Az egyetem neve
irsz NUMBER(5), -- Az egyetem irányítószáma
orszag VARCHAR2(40), -- Az egyetem országa
FOREIGN KEY(irsz, orszag) REFERENCES VAROSOK(IRSZ, ORSZAG)

);
Az Egyetemek tábla irsz és ország attribútumai idegen kulcsot alkotnak a Varosok táblához.

Szemelyek (

szigsz VARCHAR2(8) PRIMARY KEY NOT NULL, -- A személy személyi igazolvány száma
nev VARCHAR2(100), -- A személy neve
szuletesiDatum DATE, -- A személy születési dátuma
irsz NUMBER(5), -- A személy lakó városának irányítószáma
orszag VARCHAR2(40), -- A személy lakó városának országa
hallgatoE VARCHAR2(10), -- Hallgató-e a személy valamelyik egyetemen?
FOREIGN KEY(irsz,orszag) REFERENCES VAROSOK(IRSZ, ORSZAG),
FOREIGN KEY(hallgatoE) REFERENCES Egyetemek(ROVIDITES)

);
A hallgatoE attribútum NULL, ha a személy nem hallgató egyik egyetemen sem, egyébként a hallgató egyetemének a rövidítését veszi fel.
Az Szemelyek tábla irsz és ország attribútumai idegen kulcsot alkotnak a Varosok táblához.
Az Szemelyek tábla hallgatoE attribútuma idegen kulcsot alkot az Egyetemek táblához.
</pre>

## Gyakorló feladatok megoldással

### 1. feladat

- Írj PL/SQL programot, amely egy, a felhasználótól bekért életkortól
  idősebb személyekről kiírja:
  - Nevüket
  - Születési évüket és hónapot
  - Városukat
     A megoldásban használj gyűjtőtáblát az adatok tárolására.

#### Megoldás

```sql
set serveroutput on
ACCEPT eletkor PROMT 'ADJ MEG EGY ÉLETKORT'

declare
	TYPE felhasznalotipus IS TABLE OF (nev VARCHAR(20), datum DATE, varos VARCHAR(20)) INDEX BY BINARY INTEGER;
	felhasznaloTabla fehasznalotipus;
	CURSOR felhasznalolekerdezo IS SELECT Szemelyek.nev, szuletesiDatum, varosok.nev FROM Szemelyek, Varosok WHERE Szemelyek.irsz = Varosok.irsz;

beging
	kor = &eletkor
	OPEN felhasznalolekerdezo;
	LOOP
		FETCH felhasznalolekerdezo
		INTO felhasznaloTabla.nev, felhasznaloTabla.datum, felhasznaloTabla.varos;
		EXIT WHEN felhasznalolekerdezo%NOTFOUND;
		IF (GETDATE() AS DATE - felhasznaloTabla.datum) > kor AS DATE THAN
			DBMS_OUTPUT.PUT_LINE(felhasznaloTabla.nev || felhasznaloTabla.datum || felhasznaloTabla.varos)
		END IF;

	END LOOP;
	CLOSE felhasznalolekerdezo;

end;
/
```

### 2. feladat

- Írj PL/SQL programot, amely a városokhoz kiszámolja az azokban élők
  átlagos életkorát. Az átlagot egy függvény számolja ki, amelynek
  bemenő paramétere a feldolgozandó város neve. Az városokat
  tartalmazó táblán explicit kurzorral lépkedj végig. Az eredményeket
  jelenítsd is meg.
- Ugyanezt a feladatot oldd meg egy gyűjtőtábla és egy SELECT...INTO
  utasítás segítségével.

#### Megoldás

```sql
SET SERVEROUTPUT ON
ACCEPT bemeno PROMPT 'város neve: '
DECLARE
    varosnev = '&bemeno';
    atlageletkor NUMBER(30);
    TYPE varosType IS RECORD (nev VARCHAR(20), eletkor NUMBER(20));
    TYPE megyeType IS TABLE (nev VARCHAR(20), eletkor NUMBER(20)) INDEX BY BINARY INTEGER;
    megye megyeType;
    varos varosType;
BEGIN
    SELECT varos.nev, AVG(eletkor) INTO varos.nev, varos.eletkor FROM varos, szemely WHERE varos.irsz = szemely.irsz AND varos.nev = varosnev GROUP BY varos.nev;
    DBMS_Output.put_LINE(varos.nev, varos.eletkor);
END;
/
```
