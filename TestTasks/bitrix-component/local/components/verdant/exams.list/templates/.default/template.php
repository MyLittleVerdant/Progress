<table border="2px">
    <thead>
    <tr>
        <td>Дата</td>
        <td>Предмет</td>
        <td>Преподаватель</td>
        <td>Аудитория</td>
    </tr>
    </thead>
    <tbody>
    <? foreach ($arResult["ITEMS"] as $subj): ?>
        <tr>
            <td><?= $subj["ACTIVE_FROM"] ?></td>
            <td><?= $subj["NAME"] ?></td>
            <td><?= $subj["PROPERTIES"]["TEACHER"]["VALUE"] ?></td>
            <td><?= $subj["PROPERTIES"]["AUDITORIUM"]["VALUE"] ?></td>
        </tr>
    <? endforeach; ?>
    </tbody>
</table>

