## MI-PAA: Experimentální hodnocení kvality algoritmů

### Specifikace úlohy
Viz [edux](https://edux.fit.cvut.cz/courses/MI-PAA/tutorials/batoh).

### Generátor instancí problému batohu

Popis programu viz [edux](https://edux.fit.cvut.cz/courses/MI-PAA/homeworks/knapsack/generator).


Parametry jsem nastavil ve výchozím nastavení takto:

- počet věcí: 18
- počet instancí: 50
- poměr kapacity batohu k sumární váze: 0,6
- max. váha věci: 100
- max. cena věci: 250 
- exponent k: 1
- rovnováha velikosti věcí: 0

V následujících měření jsem změnil vždy jeden z parametrů.

Generátor jsem tedy zkompiloval a spusti takto:

```bash
$ gcc -o knapgen.o knapgen.c knapcore.c -lm
$ ./knapgen.o -n 25 -N 50 -m 0.6 -W 100 -C 250 -k 1 -d 0 > input.txt 2> output.txt
```
5
Počet kroků je vždy zaokrouhlován na celá čísla směrem nahoru.




### Závěr

Metoda B&B přináší zrychlení oproti metodě hrubou silou. Pouze však o konstatu, složitost je stále exponenciální, jak lze vidět z grafu. Dynamické programování přináší pseudopolynomiální řešení problému. Toho jsme schopni dosáhnout díky větší paměťové náročnosti a faktu, že jsou ceny celočíselné. Pokud by ceny byly z R, nemohli bychom pro každé potencionální řešení (tj. cenu) vytvořit řádek tabulky. FPTAS již pouze dokresluje celou situaci a ukazuje, že metoda dosahuje velmi nízké relativní chyby.

Autor: Tomáš Sušánka (susantom)

