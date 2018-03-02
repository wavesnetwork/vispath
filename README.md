# WAVES visual pathway mechanism for OpenLabyrinth 3.1

# The WAVES Project

The WAVES project combines skill sets of both academic and enterprise partners to make Scenario-based learning (SBL) more accessible for a wide range of professions.  SBL techniques are widely recognised as a key tool in the educational toolkit, for safe training in competency and decision-making.

[http://wavesnetwork.eu](http://wavesnetwork.eu)

# Description

The pathway visualizer tool extends OpenLabyrinth 3.1 and it is executed at the end of a scenario, for a single user session, when the final node of the scenario is visited. The graph contains a node for each screen card and the links among them showing the possible transitions between the states in the scenario.The tool highlights all visited nodes from a single session of the user (session_traces) in a different color. 

# Installtion

Install OpenLabyrinth 3.1 and overwrite the renderlabyrinth.php and basic.php found 
in the path: 
../application/classes/controller/renderlabyrinth.php and 
../application/views/labyrinth/skin/basic/basic.php respectively with the files placed here.
