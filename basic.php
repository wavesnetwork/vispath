<?php
/**
 * Open Labyrinth [ http://www.openlabyrinth.ca ]
 *
 * Open Labyrinth is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Open Labyrinth is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Open Labyrinth. If not, see <http://www.gnu.org/licenses/>.
 *
 * @copyright Copyright 2012 Open Labyrinth. All Rights Reserved.
 *
 */
?>
<html>
<title><?php if (isset($templateData['node_title'])) echo $templateData['node_title']; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL::base(); ?>css/skin/basic/layout.css"/>
<script type="text/javascript" src="<?php echo URL::base(); ?>scripts/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="<?php echo URL::base(); ?>scripts/jquery-ui-1.9.1.custom.min.js"></script>

<script  src="<?php echo URL::base(); ?>scripts/dhtmlxSlider/codebase/dhtmlxcommon.js"></script>
<script  src="<?php echo URL::base(); ?>scripts/dhtmlxSlider/codebase/dhtmlxslider.js"></script>
<script  src="<?php echo URL::base(); ?>scripts/dhtmlxSlider/codebase/ext/dhtmlxslider_start.js"></script>
<script  src="<?php echo URL::base(); ?>scripts/visualeditor/base64v1_0.js"></script>
<script src="http://d3js.org/d3.v3.min.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo URL::base(); ?>scripts/bootstrap-modal/css/bootstrap-modal.css"/>


<script  src="<?php echo URL::base(); ?>scripts/bootstrap-modal/js/bootstrap-modal.js"></script>
<!--<script  src="--><?php //echo URL::base(); ?><!--scripts/bootstrap/js/bootstrap.js"></script>-->
<script  src="<?php echo URL::base(); ?>scripts/bootstrap-modal/js/bootstrap-modalmanager.js"></script>


<link rel="stylesheet" type="text/css" href="<?php echo URL::base(); ?>scripts/dhtmlxSlider/codebase/dhtmlxslider.css">


<SCRIPT LANGUAGE="JavaScript">
    window.dhx_globalImgPath = "<?php echo URL::base(); ?>scripts/dhtmlxSlider/codebase/imgs/";

    function toggle_visibility(id) {
        var e = document.getElementById(id);
        if (e.style.display == 'none')
            e.style.display = 'block';
        else
            e.style.display = 'none';
    }
</SCRIPT>

<script language="javascript">
    $(document).ready(function(){
        var rem = '';
        var remMessage = '';
        var session = <?php if (isset($templateData['session'])) echo $templateData['session']; else echo ''; ?> ;

        // Timer
        <?php  if ( ($templateData['map']->timing) && isset($templateData['session']) ) { ?>
                <?php if ( isset($templateData['timer_start']) && $templateData['timer_start'] != 0) {?>
                    var sec = <?php echo $templateData['map']->delta_time - $templateData['timeForNode']; ?> ;

                    <?php if ( $templateData['map']->reminder_time > 0 && ( $templateData['map']->reminder_time < ($templateData['map']->delta_time - $templateData['timeForNode']) ) ) { ?>
                        rem = <?php echo $templateData['map']->reminder_time; ?> ;
                        remMessage = '<?php echo $templateData['map']->reminder_msg; ?>' ;
                    <?php } ?>

        <?php } else {?>

        var sec = <?php echo $templateData['map']->delta_time; ?> ;

            <?php if ( $templateData['map']->reminder_time > 0 )  {  ?>
                rem = <?php echo $templateData['map']->reminder_time; ?> ;
                remMessage = '<?php echo $templateData['map']->reminder_msg; ?>' ;
          <?php } }?>

        start_countdown(sec,rem,remMessage,session);

    <?php }?>

        // Pop-up messages for Labyrinth or Node
        <?php  if ((count($templateData['messages_labyrinth']) > 0) && isset($templateData['session'])) {
            foreach($templateData['messages_labyrinth'] as $message) {

                $time = $message->time_before;
                $time_length = $message->time_length;
                $text = $message->text;
                $title = $message->title;
                $position_type = $message->position_type;
                if ($position_type == 0) {
                    $position_type = 'inside';
                }
                else {
                    $position_type = 'outside';
                }

                $lefOrRight = '';

                switch($message->position) {
                    case 1 :
                        $position = 'top_left';
                        $lefOrRight = 'left';
                        break;
                    case 2 :
                        $position = 'top_right';
                        $lefOrRight = 'right';
                        break;
                    case 3 :
                        $position = 'bottom_left';
                        $lefOrRight = 'left';
                        break;
                    case 4 :
                        $position = 'bottom_right';
                        $lefOrRight = 'right';
                        break;
                }

                if ($message->color_custom != '')
                {
                    $color = $message->color_custom;
                }
                else {
                    switch($message->color) {
                        case 1 :
                            $color = '#FCF8E3';
                            break;
                        case 2 :
                            $color = '#F2DEDE';
                            break;
                        case 3 :
                            $color = '#DFF0D8';
                            break;
                        case 4 :
                            $color = '#D9EDF7';
                            break;
                    }
                }

                $current_pos = $position_type . '_' . $position;

                if ($message->assign_to_node == 0) {
                    if ( isset($templateData['popup_start']) && $templateData['popup_start'] != 0) {
                        $time -= $templateData['timeForNode'];
                        if ($time <= 0) {
                            continue;
                        }
                    }
                ?>
                popupTimer(<?php echo $time;?> , <?php echo $time_length;?>, '<?php echo $title;?>','<?php echo $text;?>','<?php echo $color;?>','<?php echo $current_pos;?>','<?php echo $lefOrRight;?>' );
            <?php }
                else {
                    if ($message->node_id == $templateData['node']->id) {
                       if ( isset($templateData['popup_start']) && $templateData['popup_start'] != 0) {

                ?>
                // TODO CHECK THIS PLACE
                popupTimer(<?php echo $time;?>, <?php echo $time_length;?> , '<?php echo $title;?>','<?php echo $text;?>','<?php echo $color;?>','<?php echo $current_pos;?>','<?php echo $lefOrRight;?>' );
             <?php
                            //$time -= $templateData['timeForNode'];
                            //if ($time <= 0) {
                            //    continue;
                            //}
                }
              }
            }?>
     <?php } ?>
  <?php }?>

        $(".clearQuestionPrompt").focus(function(){
            if (!$(this).hasClass('cleared')){
                $(this).val('');
                $(this).text('');
                $(this).addClass('cleared');
            }
        });
    });

    function Populate(form) {
        var myarray = new Array(<?php if (isset($templateData['alinkfil'])) echo $templateData['alinkfil']; ?>);
        var mynodes = new Array(<?php if (isset($templateData['alinknod'])) echo $templateData['alinknod']; ?>);
        var mycount = 0;
        var mybuffer = form.filler.value;

        if (mybuffer.length > 1) {
            for (var i = 0; i < myarray.length; i++) {
                for (var j = 0; j < myarray[i].length; j++) {
                    var ffv = form.filler.value.toLowerCase();
                    if (ffv == myarray[i].substring(0, j)) {
                        for (var k = i + 1; k < myarray.length; k++) {
                            var t1 = myarray[i].substring(0, j);
                            var t2 = myarray[k].substring(0, j);
                            if (t1 == t2) {
                                mycount++;
                            }
                        }
                        if (mycount < 1) {
                            form.filler.value = myarray[i];
                            form.id.value = mynodes[i];
                        }
                        else {
                            form.id.value = <?php if (isset($templateData['node'])) echo $templateData['node']->id; ?>;
                        }
                    }
                }
            }
        }
    }

    function jumpMenu(targ, selObj, restore) {
        eval(targ + ".location='<?php echo URL::base(); ?>renderLabyrinth/go/<?php echo $templateData['node']->map_id; ?>/" + selObj.options[selObj.selectedIndex].value + "'");
        if (restore) selObj.selectedIndex = 0;
    }

    function ajaxFunction(qid) {
        var qresp = $("#qresponse_" + qid).val();
        if (qresp != ''){
            qresp = B64.encode(qresp);
            var URL = "<?php echo URL::base(); ?>renderLabyrinth/questionResponse/" + qresp + "/" + qid + "/" + <?php echo $templateData['node']->id; ?>;

            var $response = $('#AJAXresponse' + qid);
            $.get(URL, function(data) {
                if(data != '') {
                    $response.html(data);
                }
            });
        }
    }

    function ajaxQU(obj, qid, qresp, qnts) {
        var URL = '<?php echo URL::base(); ?>renderLabyrinth/questionResponse/' + qresp + '/' + qid + '/' + <?php echo $templateData['node']->id; ?>;
        var check = $(obj).is(':checked');
        if (check){
            URL += '/1';
        } else {
            URL += '/0';
        }

        var $response = $('#AJAXresponse' + qresp);
        if (qnts == 1){
            $('.questionForm_'+qid+' .click').remove();
        }

        $.get(URL, function(data) {
            if(data != '') {
                $response.html(data);
            }
        });

    }

    function sendSliderValue(qid, value) {
        var URL = '<?php echo URL::base(); ?>renderLabyrinth/saveSliderQuestionResponse/' + qid;
        $.post(URL, {value: value}, function(data) {});
    }

    function ajaxBookmark() {
        var xmlhttp;
        var labsess = <?php if (isset($templateData['sessionId'])) echo $templateData['sessionId']; ?>;
        var thisnode = "<?php if (isset($templateData['node'])) echo $templateData['node']->id; ?>";
        var URL = "<?php echo URL::base(); ?>renderLabyrinth/addBookmark/" + labsess + "/" + thisnode;
        if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else if (window.ActiveXObject) {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        else {
            alert("Your browser does not support XMLHTTP for AJAX!");
        }
        xmlhttp.onreadystatechange = function () {
        }
        xmlhttp.open("POST", URL, true);
        xmlhttp.send(null);
    }

    function popupTimer(sec, lenTime, name,message,color,pos,align) {
        var time    = sec;
        var text = message;
        var title = name;
        var bgColor = color;
        var position = pos;
        var alignStyle = align;
        var length = lenTime;
        sec--;

        if ( sec > 0 ) {
            setTimeout(function(){ popupTimer(sec,lenTime,name,message,color,pos,align); }, 1000);
        }
        else {
           $("#popup_" + pos).append("<div class='alert' style='display: none; float:" + align + "; background-color:" + color +" '>" +
               "<button type='button' class='close' data-dismiss='alert'>&times;</button> <strong> " + name +
               "</strong><div id='text'>" + message +"</div></div>");

           $("#popup_"+pos+ " .alert").show();
           setTimeout(function(){ $("#popup_"+pos+ " .alert").hide() }, lenTime * 1000);
        }
    }

    function timer(sec, block,reminder, check, remMsg, session) {
        var time    = sec;

        var remTime = reminder;
        var checkReminder = check;
        var remMessage = remMsg;
        var sessionID = session;

        var hour    = parseInt(time / 3600);
        if ( hour < 1 ) hour = 0;
        time = parseInt(time - hour * 3600);
        if ( hour < 10 ) hour = '0'+hour;

        var minutes = parseInt(time / 60);
        if ( minutes < 1 ) minutes = 0;
        time = parseInt(time - minutes * 60);
        if ( minutes < 10 ) minutes = '0'+minutes;

        var seconds = time;
        if ( seconds < 10 ) seconds = '0'+seconds;

        block.innerHTML = hour+':'+minutes+':'+seconds;

        sec--;

        if (checkReminder && remTime != '' && remTime > sec){
            document.getElementsByClassName("demo btn btn-primary btn-large")[0].click();
            checkReminder = false;
        }

        if ( sec > 0 ) {
            setTimeout(function(){ timer(sec, block,remTime, checkReminder,remMessage,sessionID); }, 1000);
        }
        else {
            document.getElementsByClassName("demo btn btn-primary btn-large")[1].click();
            setTimeout(function(){ window.location.assign('/reportManager/showReport/' + sessionID); }, 2000);
        }
    }

    function start_countdown(seconds,reminderTime,remMsg,session) {
        var time = seconds;
        var remTime = reminderTime;
        var remMessage = remMsg;
        var sessionID = session;
        var block = document.getElementById('timer');
        if (reminderTime != '') {
            timer(time, block,reminderTime, true, remMessage,sessionID);
        }
        else {
            timer(time,block,'','','',sessionID);
        }
    }


    function ajaxChatShowAnswer(ChatId, ChatElementId) {
        var xmlhttp;
        var labsess = <?php if (isset($templateData['sessionId'])) echo $templateData['sessionId']; ?>;
        var URL = "<?php echo URL::base(); ?>renderLabyrinth/chatAnswer/" + ChatId + "/" + ChatElementId + "/" + labsess + <?php if (isset($templateData['node'])) echo '"/" + ' . $templateData['node']->map_id; ?>;
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET", URL, false);
            xmlhttp.send(null);
        }
        else if (window.ActiveXObject) {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            xmlhttp.open("GET", URL, false);
            xmlhttp.send();
        }
        else {
            alert("Your browser does not support XMLHTTP for AJAX!");
        }
        document.getElementById("ChatAnswer" + ChatElementId).innerHTML = "<p><b>&nbsp;&nbsp;&nbsp;&nbsp;" + xmlhttp.responseText + "</b></p>";
        document.getElementById("ChatQuestion" + ChatElementId).style.color = "grey";
    }

    $(function() {
        $.each($('.visual-display-container'), function(index, object) {
            var maxHeight = 0,
                maxWidth  = 0,
                children = $(object).children(),
                top = 0,
                height = 0,
                width = 0,
                left = 0;
            $.each(children, function(index, child) {
                top = parseInt($(child).css('top').replace('px', ''));
                height = parseInt($(child).css('height').replace('px', ''));
                if(maxHeight < (top + height)) {
                    maxHeight = top + height;
                }

                left = parseInt($(child).css('left').replace('px', ''));
                width = parseInt($(child).css('width').replace('px', ''));
                if(maxWidth < (left + width)) {
                    maxWidth = left + width;
                }
            });

            $(object).css('width', maxWidth);
            $(object).parent().css('width', maxWidth);
            $(object).css('height', maxHeight);
        });

        $('.drag-question-container').sortable({
            axis: "y",
            cursor: "move",
            stop: function(event, ui) {
                var questionId      = ui.item.parent().attr('questionId'),
                    responsesObject = [];
                ui.item.parent().children().each(function(index, value) {
                    responsesObject.push($(value).attr('responseId'));
                });

                $.post('<?php echo URL::base(); ?>renderLabyrinth/ajaxDraggingQuestionResponse', {
                    questionId: questionId,
                    responsesJSON: JSON.stringify(responsesObject)
                }, function(data) {});
            }
        });
    });
</script>
<?php
if ($templateData['skin_path'] != NULL) {
    $doc_file = DOCROOT . 'css/skin/' . $templateData['skin_path'] . '/default.css';
    if (file_exists($doc_file)) {
        $css_file = URL::base() . 'css/skin/' . $templateData['skin_path'] . '/default.css';
        echo '<link rel="stylesheet" type="text/css" href="' . ScriptVersions::get($css_file) . '" />';
    }
}

if (isset($templateData['tree']) && !empty($templateData['tree'])) { ?>
    <style>
            .node {
                cursor: pointer;
            }

            .node circle {
              fill: #fff;
              stroke: steelblue;
              stroke-width: 3px;
            }

            .node text {
              font: 12px sans-serif;
            }

            .link {
              fill: none;
              stroke: #ccc;
              stroke-width: 2px;
            }
    
    </style>
<?php } ?>
</head>

<body>
<?php if (isset($templateData['editor']) and $templateData['editor'] == TRUE) { ?>
<script language="javascript" type="text/javascript"
        src="<?php echo URL::base() ?>scripts/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
    tinyMCE.init({
// General options
        mode:"textareas",
        relative_urls:false,
        skin:"bootstrap",
        theme:"advanced",
        plugins:"autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,imgmap",
// Theme options
        theme_advanced_buttons1:"save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect,code",
        theme_advanced_buttons2:"cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,|,insertdate,inserttime,preview,|,forecolor,backcolor",
        theme_advanced_buttons3:"tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
        theme_advanced_buttons4:"insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,|,imgmap",
        theme_advanced_toolbar_location:"top",
        theme_advanced_toolbar_align:"left",
        theme_advanced_statusbar_location:"bottom",
        theme_advanced_resizing:true,
        editor_selector:"mceEditor",
        autocomplete_trigger:"",
        entity_encoding: "raw"
    });
</script>
    <?php } ?>
<div align="center">
    <div id="popup_outside_top_left" align="left">
    </div>
    <div id="popup_outside_top_right" align="right">
    </div>
    <table style="padding-top:20px;" id="centre_table" border="0" cellpadding="12" cellspacing="2">
        <tr>
            <td class="centre_td" bgcolor="#FFFFFF" align="left">

                <div id="popup_inside_top_left" align="left">
                </div>
                <div id="popup_inside_top_right" align="right">
                </div>

                <div class="edxTitleContainer"><h4 class="edxNodeTitle"><?php if (isset($templateData['node_title'])) echo $templateData['node_title']; ?></h4></div>            
                
                <div class="edxLogoContainer">  
                <img class="edxLogo" src="<?php echo URL::base(); ?>images/openlabyrinth-powerlogo-wee.jpg" height="20" width="118" alt="OpenLabyrinth" border="0"/>
                </div>
                
                <div class="clear:both"></div>
                <div class="nodeContainer">
                <?php if (isset($templateData['editor']) and $templateData['editor'] == TRUE) { ?>
                <?php if (isset($templateData['node_edit'])) { ?>
                    <form method='POST'
                          action='<?php echo URL::base(); ?>renderLabyrinth/updateNode/<?php echo $templateData['map']->id; ?>/<?php echo $templateData['node']->id; ?>'>
                        <p><input type='text' name='mnodetitle' value='<?php echo $templateData['node']->title; ?>'/>
                        </p>

                        <p><textarea name='mnodetext' cols='60' rows='20'
                                     class='mceEditor'><?php echo $templateData['node_text']; ?></textarea></p>
                        <input type='submit' name='Submit' value='Submit'/>
                    </form>
                    <p><a href='<?php echo URL::base() . 'linkManager/index/' . $templateData['map']->id; ?>'>links</a>
                        -
                        <a href='<?php echo URL::base() . 'nodeManager/index/' . $templateData['map']->id; ?>'>nodes</a>
                        -
                        <a href='<?php echo URL::base() . 'fileManager/index/' . $templateData['map']->id; ?>'>files</a>
                        -
                        <a href='<?php echo URL::base() . 'counterManager/index/' . $templateData['map']->id; ?>'>counters</a>
                        -
                        <a href='<?php echo URL::base(); ?>labyrinthManager/editMap/<?php echo $templateData['map']->id; ?>'>main
                            editor</a></p>
                    <?php } else { ?>
                    <?php if (isset($templateData['node_text'])) echo $templateData['node_text']; ?>
                    <?php if (isset($templateData['node_annotation']) && $templateData['node_annotation'] != null) echo '<div class="annotation">' . $templateData['node_annotation'] . '</div>'; ?>
                    <?php } ?>
                <?php } else { ?>
                <?php if (isset($templateData['node_text'])) echo $templateData['node_text']; ?>
                <?php if (isset($templateData['node_annotation']) && $templateData['node_annotation'] != null) echo '<div class="annotation">' . $templateData['node_annotation'] . '</div>'; ?>
                <?php } ?>
                </div>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>
                            <?php if (isset($templateData['links'])) {
							
                             echo $templateData['links'];
                        }?>
                      
                        </td>
                        <td align="right" valign="bottom" class="edxAlignRight">
                          
                            <?php if (isset($templateData['counters'])) echo $templateData['counters']; ?>
                          
                        </td>
                    </tr>
                </table>

                <div id="popup_inside_bottom_left" align="left">
                </div>
                <div id="popup_inside_bottom_right" align="right">
                </div>

            </td>
</tr>
<tr>
    <td class="centre_td" bgcolor="#FFFFFF">
        <a class="edxReviewPath" href="#" onclick="toggle_visibility('track');"><p class="edxReview">Review your pathway</p></a>
        <a class="resetLabyrinth" href='<?php echo URL::base(); ?>renderLabyrinth/reset/<?php echo $templateData['map']->id; ?><?php if(isset($templateData['webinarId']) && isset($templateData['webinarStep'])) echo '/' . $templateData['webinarId'] . '/' . $templateData['webinarStep']; ?>'>Reset your pathway</a>
        <div class="clear:both"></div>
        <div id='track' style='display:none'>
        <?php if (isset($templateData['trace_links'])) {
            echo $templateData['trace_links'];
        }
        ?>
        </div>
    </td>
</tr>
</table>
<div id="popup_outside_bottom_left" align="left">
</div>
<div id="popup_outside_bottom_right" align="right">
</div>
</div>

<div id="reminder" class="modal hide fade" tabindex="-1" data-width="760">
    <div class="modal-header">
        <h3>Reminder</h3>
    </div>
    <div class="modal-body">
      <?php echo $templateData['map']->reminder_msg; ?>
    </div>
    <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn">Close</button>
    </div>
</div>

<div id="finish" class="modal hide fade" tabindex="-1" data-width="760">
    <div class="modal-header">
        <h3>FINISH</h3>
    </div>
    <div class="modal-body">
        Time is up
    </div>
    <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn">Close</button>
    </div>
</div>

<?php if (isset($templateData['tree'])) { ?> 
<div id="olab-tree" style="clear: left; overflow: scroll;">
    <div id="node-description" style="font-size: 80%;margin-left: 20px;"></div>
</div>
<?php } ?>

<button id="remButton" class="demo btn btn-primary btn-large" href="#reminder" data-toggle="modal" style="display: none" type="submit"></button>
<button id="finishButton" class="demo btn btn-primary btn-large" href="#finish" data-toggle="modal" style="display: none" type="submit"></button>

<?php if (isset($templateData['tree'])) { ?> 
<script>

var treeData = <?php echo $templateData['tree']; ?>;

// ************** Generate the tree diagram using the d3.js library  *****************
var margin = {top: 20, right: 120, bottom: 20, left: 120},
    width = 960 - margin.right - margin.left,
    height = 500 - margin.top - margin.bottom;
    
var i = 0,
    duration = 750,
    root;

var tree = d3.layout.tree()
    .size([height, $(window).width()]);

var diagonal = d3.svg.diagonal()
    .projection(function(d) { return [d.y, d.x]; });

var svg = d3.select("#olab-tree").insert("svg",":first-child")
    .attr("width", tree.nodes(treeData[0]).length*120+"px")
    .attr("height", height + margin.top + margin.bottom)
    .append("g")
    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

root = treeData[0];
root.x0 = height / 2;
root.y0 = 0;
  
update(root);

d3.select(self.frameElement).style("height", "500px");

function update(source) {

  // Compute the new tree layout.
  var nodes = tree.nodes(root).reverse(),
      links = tree.links(nodes);

  // Normalize for fixed-depth.
  nodes.forEach(function(d) { d.y = d.depth * 180; d.filled = d.selected});

  // Update the nodes…
  var node = svg.selectAll("g.node")
      .data(nodes, function(d) { return d.id || (d.id = ++i); });

  // Enter any new nodes at the parent's previous position.
  var nodeEnter = node.enter().append("g")
      .attr("class", "node")
      .attr("transform", function(d) { return "translate(" + source.y0 + "," + source.x0 + ")"; })
      .on("click", click);
 
  nodeEnter.append("circle")
      .attr("r", 1e-6)
      .style("fill", function(d) { return d._children ? "lightsteelblue" : "#fff"; });

  nodeEnter.append("text")
      .attr("x", function(d) { return d.children || d._children ? -13 : 13; })
      .attr("dy", ".35em")
      .attr("text-anchor", function(d) { return d.children || d._children ? "end" : "start"; })
      .text(function(d) { return d.name; })
      .style("fill-opacity", 1e-6);

  // Transition nodes to their new position.
  var nodeUpdate = node.transition()
      .duration(duration)
      .attr("transform", function(d) { return "translate(" + d.y + "," + d.x + ")"; });

  nodeUpdate.select("circle")
      .attr("r", 10)
      .style("fill", function(d) { return d._children ? "lightsteelblue" : "#fff"; })
      .style("fill", function(d) { return d.filled ? "steelblue" : "#fff"; });

  nodeUpdate.select("text")
      .style("fill-opacity", 1);

  // Transition exiting nodes to the parent's new position.
  var nodeExit = node.exit().transition()
      .duration(duration)
      .attr("transform", function(d) { return "translate(" + source.y + "," + source.x + ")"; })
      .remove();

  nodeExit.select("circle")
      .attr("r", 1e-6);

  nodeExit.select("text")
      .style("fill-opacity", 1e-6);

  // Update the links…
  var link = svg.selectAll("path.link")
      .data(links, function(d) { return d.target.id; });

  // Enter any new links at the parent's previous position.
  link.enter().insert("path", "g")
      .attr("class", "link")
      .attr("d", function(d) {
        var o = {x: source.x0, y: source.y0};
        return diagonal({source: o, target: o});
      });

  // Transition links to their new position.
  link.transition()
      .duration(duration)
      .attr("d", diagonal);

  // Transition exiting nodes to the parent's new position.
  link.exit().transition()
      .duration(duration)
      .attr("d", function(d) {
        var o = {x: source.x, y: source.y};
        return diagonal({source: o, target: o});
      })
      .remove();

  // Stash the old positions for transition.
  nodes.forEach(function(d) {
    d.x0 = d.x;
    d.y0 = d.y;
  });
}

// Toggle children on click.
function click(d) {
    if (d.description) {

        document.getElementById('node-description').innerHTML = "";

        var div = document.createElement('div');

        div.className = 'desc';

        div.innerHTML = d.description;

        document.getElementById('node-description').appendChild(div);
    }
}

</script>

<?php } ?>
</body>
</html>
