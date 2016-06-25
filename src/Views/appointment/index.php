<div id="result"></div>
<p id="message-area"></p>
<div id="calendar">
    <table class="tg" id="appintment-table">
        <tr>
            <th class="trow">Date</th>
            <th class="trow">Appointment</th>
        </tr>
        <?php foreach($datePeriod as $date): ?>
            <tr>
                <td class="trow"> <?php echo $date->format('Y-m-d'); ?></td>
                <td id="name-<?php echo $date->format('Y-m-d'); ?>"> - </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <input type="hidden" id="date-from" value="<?php echo $fromDate;?>">

</div>
<div><input type="checkbox" id="offline" onchange="modeChanged();"> offline</div>
<div id="appointment-form">

    <form id="form" onsubmit="return false;">
        <div class="field_container">
            <label >Date</label>
            <select id="adate">
                <?php foreach($freeDates as $date): ?>
                    <option id="freedate-<?php echo $date; ?>">
                        <?php echo $date; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="field_container">
            <label >Name</label>
            <input type="text" id="name" placeholder="Name" maxlength="50">
        </div>
        <div class="field_container">
            <label >Email</label>
            <input type="email" id="email" placeholder="Email Address" maxlength="50">

        </div>
        <div class="field_container">
            <button id="create_button" onclick="postData();">
                <span class="button_text">Add Appointment</span>
            </button>
            <div class="clear"></div>

        </div>

    </form>
</div>

<div id="myDiv">


</div>
