SET SERVEROUTPUT ON -- kiiratás engedélyezése

ACCEPT bejovo PROMPT; -- Adatbekérés a felhasználótól

BLOKKNÉV
    DECLARE -- változók, konstansok, függvények, eljárások létrehozása
        /* Változó deklarálás: változónév [CONSTANT] addatípus [NOT NULL] [DEFAULT érték vagy := ] */
        szoveg VARCHAR2(20);
        szam NUMBER := 10;
        idx BINARY_INTEGER;


        /* Rekord TÍPUS létrehozása: TYPE rekordtipusnev IS RECORD (mezonev tipus, ... mezonev ipus);
        A rekord olyan mint egy struktúra vagy mint egy tábla egy sora: különféle tipusú adatok lehetnek benne*/
        TYPE szemelyTipus IS RECORD (kor INTEGER, nev CHAR(30), lakcim VARCHAR2(50));
        egySzemely szemelyTipus; -- szemelyTipus tipusú változó létrehozása
        egySzemely.kor := 12; -- az egySzemely rekord változó korának beállítása


        /* Gyújtőtábla TÍPUS létrehozása: TYPE táblatípusnév IS TABLE OF {oszloptípus vagy rekodtípus } INDEX BY BINARY_INTEGER;
        A gyűjtőtáblák olyanok mintha egy rekordokból álló tömböt csinálnánk. Vannak sorai, amikre indexel hivatkozhatunk. Minden sora egy rekord.*/
        TYPE tablaTipus IS TABLE OF SZEMELYEK%ROWTYPE INDEX BY BINARY_INTEGER;
        tabla tablaTipus;

        /* A gyűjtáblák használatára gyűjtábla metódusok szolgálnak:
        - EXISTS(n): igaz, ha az n-edik index létezik
        - .COUNT: a táblában lévő elemek száma
        - .FIRST/.LAST: az első és utolsó elem indexét adja vissza
        - NEXT(n): a táblában az n-et követő index értéke
        - DELETE(n): törli az n-edik indexen lévő elemet */

        /* Automati tipus meghatározás:
        - Tabla%ROWTYPE : a tábla egy sora alapján rekord tipus lemásolása (rekord tipus megadás helyett használható)
        - Tabla.cella%ROWTYPE : 
        - Tabla.vella%TYPE : a tábla egy cellájának tipusának lemásolása (változó tipus megadás helyett használható)
        */


        /* Explicit kurzorok létrehozása: CURSOR kurzornév IS lekérdezés;
        A kurzorokkal olyan lekérdezéseket hozhatunk létre, amik ahogy bejárják a táblát, sorról sorra egyesével adják vissza az adatokat
        */
        CURSOR emberKereso IS 
            SELECT nev, kor, lakcim
            FROM Tabla

        -- Kurzor függvények
        emberKereso%NOTFOUND -- igaz, ha nincs több rekord hátra
        emberKereso%ISOPEN -- igaz, ha épp megvan nyitva a kurzor
        emberKeresoL%ROWCOUNT -- Feldolgozott sorok száma
        emberKereso%FOUND -- igaz, ha sikerült rekordot feldolgozni

    BEGIN -- programkód helye
    szoveg := '&bejovo'; -- eltároljuk a bejövő adatot egy változóban szövegként. '' nélkül számként
    
    DBMS_OUTPUT.PUT_LINE(szoveg || ' !'); -- Kiiratás, összefűzés. String változóval simán össze fűzhető

    ----------- SELECT INTO -----------
    /* Olyan mint a sima SQL lekérdezés, csak változókba kérdezhetünk le vele. Egyszerre csakis egy rekord kérdezhető így le 
    SELECT oszlop1, oszlop2, ... INTO változó1, vváltozó2, ... FROM ... */
    SELECT nev, kor, lakcim INTO egySzemely.nev, egySzemely.kor, egySzemely.lakcim FROM Tabla WHERE id = 1;
    
    ----------- Vezérlési szerkezetek -----------
     IF szam < 3 THEN
        szoveg:='kevesebb mint 3';

        ELSIF (v_avgber > 4) AND (v_avgber <= 6) THEN
            szoveg:='negy es hat kozt';
        ELSE
            szoveg:='het folott';
    END IF; -- Le kell zárni az IF-et

    LOOP -- Ciklus: ismétlődik amíg nem teljesül a kilépési feltétel
      szam := szam + 1; -- azt csinálsz amit akarsz a ciklusban
      EXIT WHEN szam > 10; -- Ha ez igaz, kilép a ciklusból, lehet több is belőle
    END LOOP

    for ciklusvaltozo in 1 .. 10 loop -- 1-től 10-ig megy
      szam := szam + ciklusvaltozo; -- ide is azt csinálsz amit akarsz
    end loop


    ----------- Kurzorok használata -----------
    OPEN emberKereso; -- Kurzor végrehajtása elindul
        LOOP
            -- Következő rekord lekérdezése kurzorral: FETCH kurzornév INTO változólista;
            FETCH emberKereso INTO egySzemely.nev, egySzemely.kor, egySzemely.lakcim; -- Elmenti a következő sor (rekord) értékeit a változókba
            EXIT WHEN emberKereso%NOTFOUND; -- Ha a tábla végére értünk, kilép a ciklusból
            DBMS_OUTPUT.PUT_LINE(egySzemely.nev || ' ' || egySzemely.kor || ' ' || egySzemely.lakcim); -- kiiratás a kilépési feltétel után legyen!
        END LOOP;
    CLOSE emberKereso; -- Kurzoros feldolgozás vége
    

    ----------- Gyűjtőtáblák használata -----------
    -- feltöltés kurzorral
    OPEN emberKereso;
        idx := 1;
        LOOP
           FETCH emberKereso INTO tabla(idx);
           EXIT WHEN emberKereso%NOTFOUND;
           idx := idx +1;
        END LOOP
     CLOSE emberKereso;

     -- kiiratás
     idx := tabla.FIRST; -- legyen a változó értéke az első sor indexe
     LOOP
        DBMS_OUTPUT.PUT_LINE(tabla(idx).nev || ' ' || tabla(idx).kor || ' ' || tabla(idx).lakcim);
        EXIT WHEN idx = tabla.LAST; -- ha az utolsó indexre értünk (utolsó sor), lépjünk ki a ciklusból.
        idx = tabla.NEXT; -- ha ide elért a vezésél van még sor a táblában, állítsuk hát be a következő indexét
     END LOOP

	
END BLOKKNÉV;
/ -- per jel zárja le a blokkot!!!!!!