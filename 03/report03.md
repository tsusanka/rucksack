## MI-PAA: Experimentální hodnocení kvality algoritmů

### Specifikace úlohy
Viz [edux](https://edux.fit.cvut.cz/courses/MI-PAA/tutorials/batoh).

### Generátor instancí problému batohu

Popis programu viz [edux](https://edux.fit.cvut.cz/courses/MI-PAA/homeworks/knapsack/generator).aaa


Parametry jsem nastavil ve výchozím nastavení takto:

- počet věcí: 18
- počet instancí: 50
- poměr kapacity batohu k sumární váze: 0,6
- max. váha věci: 100
- max. cena věci: 250 
- exponent k: 1
- rovnováha velikosti věcí: 0

Generátor jsem tedy zkompiloval a spustil takto:

```bash
$ gcc -o knapgen.o knapgen.c knapcore.c -lm
$ ./knapgen.o -n 18 -N 50 -m 0.6 -W 100 -C 250 -k 1 -d 0 > input.txt 2> output.txt
```

### Měření

Počet kroků je vždy zaokrouhlován na celá čísla směrem nahoru.

V následujících měřeních jsem vždy změnil jeden z parametrů.

##### Maximální váha věcí



### Závěr



Autor: Tomáš Sušánka (susantom)

