<?php
/**
 * Created by PhpStorm.
 * User: malak
 * Date: 12/15/18
 * Time: 9:17 PM
 */
?>
<div style="padding: 0px; margin: 0px;">
    <div style="border-bottom-color: #000000; border-bottom-width: 1px; border-bottom-style: solid; clear: both;">
        <div>
            <h1>Tax Estimator</h1>
        </div>
        <div>
            <ul>
                <il><a href="<?= url("/"); ?>">Home Page</a></il>
                |
                <il><a href="<?= url("/tax/estimate"); ?>">Tax Estimator</a></il>
            </ul>
        </div>
    </div>
    <br/>
    <div>
        <p><b>Pls fill you data to estimate your income tax in Jordan.</b></p>

        <?= Form::open(['url' => '/tax/estimate', 'method' => 'post', 'id' => 'tax-calculator-form']); ?>

        <?= Form::label('income', 'Total income (JOD)'); ?>
        <?= Form::number('income', 0, ['placeholder' => 'Total income (JOD)']); ?>
        <br/><br/>

        <?= Form::label('resident', 'Are you a resident of Jordan ?'); ?>
        <?= Form::select('resident', [
            '' => 'Select',
            'true' => 'Yes',
            'false' => 'No',
        ]);
        ?>
        <br/><br/>

        <?= Form::label('marital_status', 'Marital status'); ?>
        <?= Form::select('marital_status', [
            '' => 'Select',
            'true' => 'Married',
            'false' => 'Single',
        ]);
        ?>
        <br/><br/>

        <?= Form::label('spouse_income', 'Total spouse income (JOD)'); ?>
        <?= Form::number('spouse_income', 0, ['placeholder' => 'Total spouse income (JOD)']); ?>
        <br/><br/>


        <?= Form::label('spouse_resident', 'Is your spouse a resident of Jordan ?'); ?>
        <?= Form::select('spouse_resident', [
            '' => 'Select',
            'true' => 'Yes',
            'false' => 'No',
        ]);
        ?>
        <br/><br/>

        <?= Form::submit('Submit'); ?>
        <?= Form::close(); ?>
    </div>

    <br/>
    <hr/>
    <br/>

    <div class="resposne"></div>
</div>

<!-- load jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {

        $("#tax-calculator-form").submit(function (e) {

            e.preventDefault();
            $(".resposne").html("");

            let form = $(this);
            let url = form.attr('action');

            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(),
                dataType: 'json',
                success: function (response) {
                    let html = "Your tax = [ " + response.data.tax + " ] JOD.";
                    html += "<br/>";
                    if (response.data.is_married == "true") {
                        html += "Your spouse tax = [ " + response.data.spouse_tax + " ] JOD.";
                    }
                    $(".resposne").attr("style", "color: green;");
                    $(".resposne").html(html);
                },
                error: function (response) {
                    let html = "Bad Request! Errors below: <br/><br/>";
                    let msgs = response.responseJSON.data;
                    $.each(msgs, function (element, value) {
                        html += value + "<br/>";
                    });
                    $(".resposne").attr("style", "color: red;");
                    $(".resposne").html(html);
                },
            });

        });
    });
</script>

