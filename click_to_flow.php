<?php
//only run if this is a hook call
if(defined("HOOK") AND HOOK){
    //Add the twilio libarary so we can get information about calls
    require_once(APPPATH . 'libraries/twilio.php');

    //We're making a call using the restClient using the twilio credentials for this VBX instalation
    $this->twilio = new TwilioRestClient($this->twilio_sid,
    $this->twilio_token,
    $this->twilio_endpoint);

    if(!isset($_POST['Flow'])){
        echo json_encode(array('isError' => true, 'message' => 'no flow name given'));
        return;
    }

    $flows = OpenVBX::getFlows(array('name' => $_POST['Flow']));

    if(!isset($flows[0])){
        echo json_encode(array('isError' => true, 'message' => 'invlalid flow name'));
        return;
    }

    $flow = $flows[0];

    if(is_null($flow->data)){
        echo json_encode(array('isError' => true, 'message' => "flow '{$flow->name}' not valid for calls"));
        return;
    }

    if(count($flow->numbers) == 0){
        echo json_encode(array('isError' => true, 'message' => "flow '{$flow->name}' has no attached numbers"));
        return;
    }

    if(!isset($_POST['Called'])){
        echo json_encode(array('isError' => true, 'message' => 'missing number to call'));
        return;
    }

    $response = $this->twilio->request("Accounts/{$this->twilio_sid}/Calls",
        'POST',
        array(
            'Caller' => $flow->numbers[0],
            'Called' => normalize_phone_to_E164($_POST['Called']),
            'Url' => site_url('twiml/start/voice/'.$flow->id)));

    if($response->IsError){
        echo json_encode(array('isError' => true, 'message' => $response->ErrorMessage));
        return;
    }

    echo json_encode(array('isError' => false, 'message' => 'call placed'));
    return;

} else {
?>
<div class="vbx-plugin">

	<h3>Click-To-Flow</h3>
        <p>Initate a call from any flow by posting the flow name and the number
        to call:<br>
        <pre><?php echo site_url("hook/click_to_flow");?></pre>
        </p>
        <p>The flow must be connected to a number, and be a valid flow for voice</p>
        <p>Example:
        <pre>
        <?php
            $example = "\n<form method='POST' action='" . site_url("hook/click_to_flow") . "'>\n";
            $example .= "\t<input type='text' name='Called'>\n";
            $example .= "\t<input type='hidden' name='Flow' value='Name'>\n";
            $example .= "\t<input type='submit' value='Call Me'>\n";
            $example .= "</form>";
            echo htmlspecialchars($example);
        ?>
        </pre>
        <p>
        <p>A JSON status will be returned.</p>
        <p><b>WARNING: This is a proof-of-concept requiring modified OpenVBX code to run. Please treat it as such.</b></p>

</div>


<?php
}
?>
