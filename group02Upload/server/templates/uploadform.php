<?php include 'header.php'; ?>
<div class="page-header">
  <h1>Post Tester</h1>
</div>
<form method="POST" action="upload.php">
    <p class="lead">
        Use this form to test JSON uploading to the server.
    </p>
    <p>Anything you type below will be sent as the <code>data</code> parameter in a POST request to the upload script.</p>
    <p>Note that this live: anything you submit, if valid, <em>will</em> be submitted and stored into the database.</p>
    <div class="form-group">
        <textarea style="font-family:monospace; height:600px;" class="form-control" name="data">
{
    "authorization": {
        "hash": "427339AC646C25EFFA6B624CE776FB4FEE99CEDA",
        "salt": "swordfish"
    },
    "walk": {
        "title": "Whitehall Wander",
        "shortDesc": "A short walk around Westminster",
        "longDesc": "A walk around London, viewing sights such as Downing Street, Trafalgar Square, and Scotland Yard",
        "locations": [
            {
                "latitude": 51.5034,
                "longitude": -0.1276,
                "timestamp": 0,
                "descriptions": [
                    ["Downing Street","The residence of the Prime Minister."],
                    ["10 Downing Street", "Where the PM lives."]
                ],
                "images": [
                ]
            },
            {
                "latitude": 51.4986,
                "longitude": -0.1331,
                "timestamp": 60,
                "descriptions": [
                    ["New Scotland Yard","The home of the Met"],
                    ["Metropolitan Police HQ","Also known as New Scotland Yard"]
                ],
                "images": [
                ]
            }
        ]
    }
} </textarea>
        <button type="submit" class="btn btn-default">Submit</button>
    </div>
</form>
