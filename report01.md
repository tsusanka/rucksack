## MI-PAA: Řešení problému batohu metodou hrubé síly a jednoduchou heuristikou

### Specifikace úlohy
Viz [edux](https://edux.fit.cvut.cz/courses/MI-PAA/tutorials/batoh).

### Rozbor možných variant řešení

##### Řešení hrubou silou

Procházíme všechny možnosti. Máme zaručeno, že nalezneme optimální řešení. Složitost je O(2^n).

##### Řešení heuristikou poměr cena/váha

Nejprve si pro každou položku spočítáme poměr cena/váha. Poté setřídíme. Do batohu poté přidáváme položky, které mají nejlepší poměr. Složitost je O(nlogn), avšak algoritmus nezaručuje nalezení optimálního řešení.

### Popis kostry algoritmu

Soubor `main.php` obsahuje prvotní logiku programu. Načte data ze souboru a řádek po řádku vytváří instanci třídy `RuckSackProblemBrute` (příp. `RuckSackProblemRatio`). Tyto třídy jsou potomky abstraktní třídy `BaseRuckSackProblem`, která má pomocné metody pro zpracování vstupu a výstupu. Také definuje abstraktní metodu `solve()`, která je zodpovědná za spočtení řešení.

`RuckSackProblemBrute` vytváří rekurzi o *n* větvích. V každé části provadíme jendo rekurzivní volání pro hodnotu TRUE a jedno pro FALSE. Tímto způsobem vygenerujeme všechny možné varianty. Pro každou tuto variantu voláme funkci `check()`, která spočítá váhu a cenu daného řešení. Pokud je váha validní (nepřesahuje hmotnost baťohu) a pokud je cena nejvyšší nalezená, uložíme tuto konfiguraci. Na závěr řešení vypíšeme.

`RuckSackProblemRatio` si nejdříve spočte poměr cena/váha ke každé položce. Poté tyto poměry seřadí. Následně se volá funkce `add()`, která  podle seřazených hodnot postupně přidává položky do batohu.

### Naměřené výsledky

|  n  |    čas      |
|:----|:------------|
|  4  |  0,0004s    |
| 10  |  0,00834s   |
| 15  |  0,3362s    |
| 20  |  12,357s    |
| 22  |  52,98152s  |
| 25  |  453,79622s |

Měřeno na:

- PHP 5.6.14
- Linux 3.18.22 Manjaro distribution based on Arch Linux
- Intel(R) Core(TM) i7-3517U CPU @ 1.90GHz
- 4 GB RAM

### Závěr

Autor: Tomáš Sušánka (susantom)

