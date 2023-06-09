<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Automobile statistics</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>

    <h1>Automobile statistics tool</h1>
    <form method="GET" action="index.php">
        <fieldset>
            <legend>Filtering options</legend>

            <?php if (isset($error)) { ?>
                <div class="error">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php } ?>

            <select name="manufacturer" id="manufacturer">
                <option value="">Pick a brand</option>
                <?php foreach ($manufacturers as $id => $title) { ?>
                    <option value="<?php echo $id; ?>"><?php echo htmlspecialchars($title); ?></option>
                <?php } ?>
            </select>

            <select name="color" id="color">
                <option value="">Pick a color</option>
                <?php foreach ($colors as $id => $title) { ?>
                    <option value="<?php echo $id; ?>"><?php echo htmlspecialchars($title); ?></option>
                <?php } ?>
            </select>

            <label for="year">Production year</label>
            <input type="number" name="year" min="2010" max="2020" />

            <button type="submit">Apply filters </button>
        </fieldset>

    </form>

    <section id="main">
        <?php
        if (isset($results)) {
        ?>
            <table>
                <tr>
                    <th>Brand/Manufacturer</th>
                    <th>Model</th>
                    <th>Count</th>
                </tr>
                <?php
                while ($result = $results->fetch_array(MYSQLI_NUM)) {
                ?>
                    <tr>
                        <td><?php echo $result[0] ?></td>
                        <td><?php echo $result[1] ?></td>
                        <td><?php echo $result[2] ?></td>
                    </tr>
                <?php
                }
                ?>
            </table>
        <?php
        }
        ?>
    </section>

</body>

</html>