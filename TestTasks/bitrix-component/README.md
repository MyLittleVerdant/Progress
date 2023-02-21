2. Написать PHP код который создаст в Битриксе:
- Инфоблок "Расписание экзаменов"
- Свойства для элементов этого инфоблока:
- "Аудитория" тип целое число
- "Преподаватель" тип строка
- и 5 элементов этого инфоблока с заполненными полями:
- Название (стандартное поле инфоблока)
- Аудитория
- Преподаватель
- Дата начала (стандартное поле инфоблока)

3. Разработать собственный компонент exams.list который должен выводить таблицу с расписанием экзаменов. (Бездумное копирование news.list запрещено)

Поля таблицы:
- "Дата",
- "Предмет" (название элемента)
- "Преподаватель"
- "Аудитория"

Элементы должны быть отсортированы по дате начала

4. Создать страницу exams.php на которой вызвать этот компонент. В качестве передаваемых в компонент параметров должен быть ID инфоблока.

- файл local/scripts/install.php - код для создания инфоблока, свойств инфоблока и элементов.
- папка local/components/verdant - папка с кодом компонента и шаблоном
- файл exams.php - файл с вызовом компонента.