## MI-PAA: Seznámení se se zvolenou pokročilou iterativní metodou na problému batohu

### Specifikace úlohy
Viz [edux](https://edux.fit.cvut.cz/courses/MI-PAA/tutorials/batoh).

### Zadání
Viz [edux](https://edux.fit.cvut.cz/courses/MI-PAA/homeworks/04/start).

### Algoritmus

Algoritmus jsem zvolil simulované ochlazování (Simulated annealing).

@todo popis

### Měření

K měření jsem použil testovací data, která obsahují i řešení. Použil jsem soubory `knap_40.inst.dat` a `knap_40.sol.dat`, tedy zadání s 40 položkami. Program rovnou načte soubor s řešením a vyhodnotí relativní chybu. Jako další argumenty bere parametry simulovaného ochlazování v pořadí:

- míra ochlazování
- equilibrium
- počáteční teplota
- koncová teplota

Příklad spuštění:

`./main.php data/input/knap_40.inst.dat data/output/knap_40.sol.dat 0.94 5 3 0.1`




### Závěr



Autor: Tomáš Sušánka (susantom)

