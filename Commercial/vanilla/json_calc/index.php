<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

<div class="screen" style="display: flex">

    <form action="converter.php" method="post" id="collect">
        <input type="text" name="type" value="collect" hidden>
        <div class="row">
            <label for="spreadsheetId">Введите id таблицы</label>
            <input type="text" id="spreadsheetId" name="spreadsheetId">
        </div>
        <div class="row">
            <label for="range">Введите страницу/диапазон (Оставьте пустым для обработки всей таблицы)</label>
            <input type="text" id="range" name="range">
        </div>
        <div class="params" id="paramsCollect">
            <div class="row">
                <label for="field_1">Введите порядковый номер 1 столбца для подсчета</label>
                <input type="text" id="field_1" name="field_1">
            </div>
            <div class="row">
                <label for="field_2">Введите порядковый номер 2 столбца для подсчета</label>
                <input type="text" id="field_2" name="field_2">
            </div>
        </div>
        <div class="row">
            <label for="resultRow">Введите порядковый номер результирующего столбца</label>
            <input type="text" id="resultRow" name="resultRow">
        </div>
        <button type="submit" style="margin: 10px">Клик</button>

        <div class="bttn" style="margin: 10px">
            <button class="addCollectField">+поле</button>
        </div>
    </form>
    <form action="converter.php" method="post" id="calc" style="margin-left: 20px">
        <input type="text" name="type" value="calc" hidden>
        <div class="params" id="paramsCalc">
            <div class="row">
                <label for="field_1">Введите значение 1 для подсчета</label>
                <input type="text" id="field_1" name="field_1" class="input">
            </div>
            <div class="row">
                <label for="field_2">Введите значение 2 для подсчета</label>
                <input type="text" id="field_2" name="field_2" class="input">
            </div>
        </div>

        <button type="submit" style="margin: 10px">Клик</button>

        <div class="bttn" style="margin: 10px">
            <button class="addCalcField">+поле</button>
        </div>
    </form>

</div>
<script>
    let count = 3;
    document.querySelector(".addCollectField").addEventListener("click", function (e) {
        e.preventDefault();
        let templ = `<div class="row">
            <label for="field_${count}">Введите порядковый номер ${count} столбца для подсчета</label>
            <input type="text" id="field_${count}" name="field_${count}">
        </div>`

        let d1 = document.getElementById('paramsCollect');
        d1.insertAdjacentHTML('beforeend', templ);
        count++;
    })

    document.querySelector(".addCalcField").addEventListener("click", function (e) {
        e.preventDefault();
        let templ = `<div class="row">
            <label for="field_${count}">Введите значение ${count}  для подсчета</label>
            <input type="text" id="field_${count}" name="field_${count}" class="input">
        </div>`

        let d1 = document.getElementById('paramsCalc');
        d1.insertAdjacentHTML('beforeend', templ);
        count++;
    })

    // $('#calc').on('submit', function (e) {
    //     e.preventDefault();
    //     let form = $(this);
    //     $.ajax({
    //         type: form.prop('method'),
    //         url: form.prop('action'),
    //         data: form.serialize(),
    //         dataType: "json",
    //         success: function (response) {
    //             console.log(response)
    //             if (!response.error) {
    //                 form[0].reset()
    //             } else {
    //                 let templ = `<div class="row">
    //         <label for="re
    //         sult">Результат:</label>
    //         <input type="text" id="result" name="result" value="">
    //     </div>`
    //
    //                 let d1 = document.getElementById('paramsCalc');
    //                 d1.insertAdjacentHTML('afterend', templ);
    //             }
    //         }
    //     })
    // })

    $('#calc').on('submit', function (e) {
        e.preventDefault();
        let form = $(this);
        $.ajax({
            type: form.prop('method'),
            url: form.prop('action'),
            data: form.serialize(),
            dataType: "json",
            success: function (response) {
                if (!response.error) {
                    let keys = [];
                    $('.input').each(function () {
                        keys.push($(this).val());
                    })
                    let data = JSON.parse(response.msg);
                    let result = getResult(data['forms'], keys, 0, keys.length)
                    console.log(result)
                } else {
                    console.log("ГГ")
                }
            }
        })


    })


</script>
<script>
    function getResult(data, keys, curlvl, lvl) {

        if (curlvl !== lvl) {
            for (const [index, key] of Object.entries(keys)) {
                if (data[key] != undefined) {
                    let newKeys = {};
                    Object.assign(newKeys, keys);
                    delete newKeys[index];
                    return getResult(data[key], newKeys, ++curlvl, lvl)
                }
            }
            return data;

        } else {
            return data;
        }

    }
</script>