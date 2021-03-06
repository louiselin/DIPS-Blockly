// Do not edit this file; automatically generated by build.py.
'use strict';


// Copyright 2012 Google Inc.  Apache License 2.0
Blockly.DIPS = new Blockly.Generator("DIPS");


Blockly.DIPS.init = function(a) {
    Blockly.DIPS.definitions_ = Object.create(null);
    Blockly.DIPS.functionNames_ = Object.create(null);
    Blockly.DIPS.variableDB_ ? Blockly.DIPS.variableDB_.reset() : Blockly.DIPS.variableDB_ = new Blockly.Names(Blockly.DIPS.RESERVED_WORDS_);
    var b = [];
    a = Blockly.Variables.allVariables(a);
    
};
Blockly.DIPS.finish = function(a) {
    var b = [],
        c;
    for (c in Blockly.DIPS.definitions_) b.push(Blockly.DIPS.definitions_[c]);
    delete Blockly.DIPS.definitions_;
    delete Blockly.DIPS.functionNames_;
    Blockly.DIPS.variableDB_.reset();
    return b.join("\n\n") + "\n\n\n" + a
};

Blockly.DIPS.quote_ = function(a) {
    a = a.replace(/\\/g, "\\\\").replace(/\n/g, "\\\n").replace(/'/g, "\\'");
    return a
};
Blockly.DIPS.scrub_ = function(a, b) {
    var c = "";
    if (!a.outputConnection || !a.outputConnection.targetConnection) {
        var d = a.getCommentText();
        d && (c += Blockly.DIPS.prefixLines(d, "// ") + "\n");
        for (var e = 0; e < a.inputList.length; e++) a.inputList[e].type == Blockly.INPUT_VALUE && (d = a.inputList[e].connection.targetBlock()) && (d = Blockly.DIPS.allNestedComments(d)) && (c += Blockly.DIPS.prefixLines(d, "// "))
    }
    e = a.nextConnection && a.nextConnection.targetBlock();
    e = Blockly.DIPS.blockToCode(e);
    return c + b + e
};
// USE THIS PART
Blockly.DIPS.controls_if = function(a) {
    for (var b = 0, c = Blockly.DIPS.valueToCode(a, "IF" + b) || "false", 
        d = Blockly.DIPS.statementToCode(a, "DO" + b).replace("  ", ""), 
        e = "when(" + c + "){" + d + "}", b = 1; b <= a.elseifCount_; b++) 
            c = Blockly.DIPS.valueToCode(a, "IF" + b) || "false", 
            d = Blockly.DIPS.statementToCode(a, "DO" + b), 
            e += "when(" + c + "){" + d + "}";
            a.elseCount_ && (d = Blockly.DIPS.statementToCode(a, "ELSE"), e += " otherwise{" + d.replace(",0","").replace("  ", "") + "}");
    return e + ","
};
