sol="../data/output/knap_"
sol+=$1
sol+=".sol.dat"
/usr/bin/diff -y --suppress-common-lines $1 $sol | grep '^' | wc -l 
