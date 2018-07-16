<?php
require_once('./config.php');
if (empty($_GET) && empty($_POST)) {
    exit('Не переданы параметры');
}
if (!empty($_GET) && (!isset($_GET['testid']) || empty($_GET['testid']))) {
    exit('Передайте параметр testid');

} elseif (!empty($_POST) && (!isset($_POST['testid']) || empty($_POST['testid']))) {
    exit('Тест прошёл не корректно');
}
if (!empty($_GET['testid'])) {
    $testId = 'id' . $_GET['testid'];
} else {
    $testId = $_POST['testid'];
}
$testJson = file_get_contents($testsDir . $testId . '.json');
if ($testJson === false) {
    exit("Тест $testId не найден");
}
$testData = json_decode($testJson, true);
$testName = !empty($testData['title']) ? $testData['title'] : 'Безымянный тест';
if (empty($testData['questions'])) {
    exit('Пустой тест');
}
$testQuestionsArray = $testData['questions'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        <?php echo !empty($_GET) ? 'Тест - ' : 'Результат теста - ' ;?>
        <?php echo $testId; ?>
    </title>
</head>
<body>

<?php if (!empty($_GET)): ?>
    <!-- GET -->

    <h1>
        <?php echo $testName; ?>
    </h1>
    <form action="test.php" method="POST">
        <?php $fieldNamePrefix = 'q'; ?>
        <?php foreach ($testQuestionsArray as $questionCounter => $question): ?>
            <fieldset>
                <?php if (isset($question['title'])): ?>
                    <h3>
                        <?php echo $question['title'] ?>
                    </h3>
                <?php else: ?>
                    <?php continue; ?>
                <?php endif; ?>

                <?php $fieldname = $fieldNamePrefix . (1 + $questionCounter); ?>
                <?php $answers = $question['answers']; ?>

                <?php foreach ($answers as $answer): ?>
                    <?php if (empty($answer['title'])): ?>
                        <?php continue; ?>
                    <?php endif; ?>
                    <?php $correct = isset($answer['correct']) && $answer['correct'] ? 'correct' : ''; ?>

                    <label>
                        <input type="radio" name="<?php echo $fieldname; ?>" value="<?php echo $correct; ?>">
                        <?php echo $answer['title'] ?>
                    </label>
                <?php endforeach; ?>

            </fieldset>
        <?php endforeach; ?>

        <input type="hidden" name="testid" value="<?php echo $testId; ?>" />
        <input type="submit" placeholder="Отправить"/>
    </form>

<?php elseif (!empty($_POST)): ?>
    <!-- POST -->
    <h2>Результаты теста:</h2>

    <ul>
        <?php $resultCounter = 0; ?>
        <?php foreach ($_POST as $fieldName => $data): ?>
            <?php if ($fieldName === 'testid'): ?>
                <?php continue; ?>
            <?php endif; ?>

            <?php $questionTitle = $testQuestionsArray[$resultCounter++]['title']; ?>
            <?php $questionStatus = !empty($data); ?>

            <li>
                <?php echo $questionTitle . ' - ' . ($questionStatus ? 'Верно' : 'Не верно'); ?>
            </li>
        <?php endforeach; ?>
    </ul>

<?php endif; ?>
</body>
</html>
