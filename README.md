# WAVES Visual Pathway 

# The WAVES Project

The WAVES project combines skill sets of both academic and enterprise partners to make Scenario-based learning (SBL) more accessible for a wide range of professions.  SBL techniques are widely recognised as a key tool in the educational toolkit, for safe training in competency and decision-making.

[http://wavesnetwork.eu](http://wavesnetwork.eu)

# Description

The pathway visualizer tool extends OpenLabyrinth 3.1 and it is executed at the end of a scenario, for a single user session, when the final node of the scenario is visited. The graph contains a node for each screen card and the links among them showing the possible transitions between the states in the scenario.The tool highlights all visited nodes from a single session of the user (session_traces) in a different color. 

# Online demo

Visit the following link:

<i>Coming soon..</i>

# Installation

1. Install OpenLabyrinth 3.1 following the instrcution at [https://github.com/olab/Open-Labyrinth/wiki/Installing-Open-Labyrinth](https://github.com/olab/Open-Labyrinth/wiki/Installing-Open-Labyrinth)

2. Overwrite the  ```renderlabyrinth.php``` and ```basic.php``` found 
in the path: 
 ```php
 ../application/classes/controller/renderlabyrinth.php 
```
 and 
```php
../application/views/labyrinth/skin/basic/basic.php respectively with the files placed here.
 ```

# License 
WAVES Visual Pathway is licensed under the MIT Open Source license. For more information, see the LICENSE file in this repository.
