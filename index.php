<?php
include "conn.php";
?>
<html>
<head>
  <meta charset="utf-8">
  <title>Blockly Demo: Generating DIPS</title>
  <script src="blockly_compressed.js"></script>
  <script src="blocks_compressed.js"></script>
  <script src="dips_blockly.js"></script>
  <script src="dips.js"></script>
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
  <style>
    body {
      background-color: #fff;
      font-family: sans-serif;
      margin-left: 20px;
    }
    h1 {
      font-weight: normal;
      font-size: 140%;
    }
  </style>
</head>
<body>
  <h1>Generating DIPS</h1>
  <p>This is a simple demo of generating code from blocks.</p>
  <p>
    <button class="btn btn-default" onclick="showCode()">RUN</button>
    <a class="btn btn-default" href="create_block.php">CREATE</a>
  </p>
  
  <div id="blocklyDiv" style="height: 480px; width: 500px;"></div>

  <xml id="toolbox" style="display: none">
    <category name="Logic" colour="210">
      <block type="controls_if"></block>
      <!-- <block type="logic_operation"></block> -->
    </category>
    <category name="Triggers" colour="410">
    <?php
      $sql_select = "SELECT * FROM workspace WHERE attr='Trigger'";
      $stmt = $conn->query($sql_select);
      $registrants = $stmt->fetchAll();
      if(count($registrants) > 0) {
        foreach($registrants as $registrant) {
    ?>
      <block type="<?=$registrant['name']?>"></block>
    <?php
      }
        } else {
          echo "<h3>No case is created.</h3>";
      }
    ?>
    </category>
    <category name="Actions" colour="270">
    <?php
      $sql_select = "SELECT * FROM workspace WHERE attr='Action'";
      $stmt = $conn->query($sql_select);
      $registrants = $stmt->fetchAll();
      if(count($registrants) > 0) {
        foreach($registrants as $registrant) {
    ?>
      <block type="<?=$registrant['name']?>"></block>
    <?php
      }
        } else {
          echo "<h3>No case is created.</h3>";
      }
    ?>
    </category>  
  </xml>

<!-- Intitialize -->
  <xml id="startBlocks" style="display: none">
    <block type="controls_if" inline="false" x="20" y="20">
      <value name="IF0">
        <block type="rightHandUp">
          <value>righthandup</value>
        </block>
      </value>
      <statement name="DO0">
        <block type="noseRaise">
          <value>noseRaise</value>
        </block>
      </statement>
    <next>
    </block>
  </xml>

<?php
      $sql_select = "SELECT * FROM workspace WHERE attr='Trigger'";
      $stmt = $conn->query($sql_select);
      $registrants = $stmt->fetchAll();
      if(count($registrants) > 0) {
        foreach($registrants as $registrant) {
          $triggername = $registrant['name'];
          $imagename = $registrant['image'];
          echo  "<script>Blockly.Blocks." . $triggername . " ={ " .
                  "init: function() { " .
                  "var image = new Blockly.FieldImage('media/image/".$imagename."', 30, 50, '". $triggername . "');" .
                  "this.setOutput(true, null);" .
                  "this.setColour(410);" .
                  "this.appendDummyInput().appendField(image);" . 
                  "}};" .
                "Blockly.DIPS." . $triggername . "= function(a) { " .
                  "return ['" . $triggername . "']" . 
                "};" . 
                "</script>";
            }
        } else {
          echo "<h3>No case is created.</h3>";
      }
  ?>

  <?php
      $sql_action = "SELECT * FROM workspace WHERE attr='Action'";
      $stmt = $conn->query($sql_action);
      $registrants = $stmt->fetchAll();
      if(count($registrants) > 0) {
        foreach($registrants as $registrant) {
          $triggername = $registrant['name'];
          $imagename = $registrant['image'];
          // echo $triggername;
          // echo $imagename;
          echo  "<script>Blockly.Blocks." . $triggername . " ={ " .
                  "init: function() { " .
                  "var image = new Blockly.FieldImage('media/image/".$imagename."', 50, 30, '". $triggername . "');" .
                  "this.setOutput(false, null);" .
                  "this.setPreviousStatement(true);" . 
                  "this.setColour(270);" .
                  "this.appendDummyInput().appendField(image).appendField('" . $triggername . "');" . 
                  "}};" .
                "Blockly.DIPS." . $triggername . "= function(a) { " .
                  "return '" . $triggername . "'" . 
                "};" . 
                "</script>";
            }
        } else {
          echo "<h3>No case is created.</h3>";
      }
  ?>


  <script>
    var workspace = Blockly.inject('blocklyDiv',
        {media: 'media/',
         toolbox: document.getElementById('toolbox')});
    Blockly.Xml.domToWorkspace(document.getElementById('startBlocks'), workspace);

    function showCode() {
      // Generate DIPS code and display it.
      // Blockly.DIPS.INFINITE_LOOP_TRAP = null;
      var code = Blockly.DIPS.workspaceToCode(workspace);
      code = code.substring(0,code.length-1);
      console.log(code);
      console.log($.get('http://localhost:12345', {rule: code}));
    }
  </script>

</body>
</html>
