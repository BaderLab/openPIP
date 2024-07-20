# openPIP: The open-source protein interaction platform
![image](https://user-images.githubusercontent.com/7611596/156920773-e31827da-760d-4061-adf9-50e72f690ce1.png)

The Open-source Protein Interaction Platform (openPIP) is a customizable web portal designed to host experimental PPI maps. Such a portal is often required to accompany a paper describing the experimental data set, in addition to depositing the data in a standard repository. No coding skills are required to set up and customize the database and web portal. OpenPIP has been used to build the databases and web portals of two major protein interactome maps, the Human and Yeast Reference Protein Interactome maps (HuRI and YeRI, respectively). OpenPIP is freely available as a ready-to-use Docker container for hosting and sharing PPI data with the scientific community at http://openpip.baderlab.org/ and the source code can be downloaded from https://github.com/BaderLab/openPIP/

## openPIP features:
-PPI Database Construction

-Querying the PPI Data

-Results Visualization, Refinement, and Download

-Integration with Other Tools

-Support for Touch and Small Screens

## Portal Customization
-Interface Customization

-Search Option Customization

-Customization of the Network Visualization

-Editable Page Contents

## Installation:
1. Clone this repo.
2. Give suitable permissions to`.sh` files (`chmod +x start.sh` and `chmod +x populate_db.sh`)
3. To run the server : ./start.sh
4. To populate database :
    * unzip Docker OpenPIP package/db/dev10.0_huri.zip
    * Copy the dev10.0_huri.sql file inside the `openPIP` folder or any other .sql file through which you want to populate the database.
    * `./populate_db.sh`
    * `mysql -uroot --password=secret` (inside the docker container cli)
    * `USE huri;`(inside mysql cli)
    * `source dev10.0_huri.sql` (inside mysql cli)

## openPIP webpage: 
openPIP was developed at Bader Lab at the University of Toronto. The openPIP webpage is here(http://baderlab.org/Software/openPIP).