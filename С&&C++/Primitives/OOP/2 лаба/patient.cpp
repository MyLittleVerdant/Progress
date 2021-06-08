#include <iostream>
#include <time.h>
#include <limits.h>
using namespace std;


class Patient {

public:
    string firstName, lastName, fatherName;
    string address;
    int year;
    int number;
    string diagnosis;

    void print()
    {
        cout << this->lastName << " " << this->firstName << " " << this->fatherName << endl;
        cout << "Год рождения: " << this->year << endl; 
        cout << "Номер карты: " << this->number << endl; 
        cout << "Диагноз: " << this->diagnosis << endl; 
    }

};


struct NotFoundException : public exception {
   const char * what () const throw () {
      return "Ошибка: диагноз не найден!\n";
   }
};

struct IncorrectDataException : public exception {
   const char * what () const throw () {
      return "Ошибка: неверные вхоные данные!\n";
   }
};



int user_prompt(int from, int to);
void find_diagnosis(Patient * arr, int n);
void find_number_in_interval(Patient * arr, int n);
void find_year_in_interval(Patient * arr, int n);
void fill(Patient * people, int n);



int main ()
{
    Patient people[10];

    fill(people, 10);


    do {
        cout << "\nВыберите действие:\n"
             << "1. Список пациентов, имеющих данный диагноз\n"
             << "2. Список пациентов, номер медицинской карты которых находится в заданном интервале\n"
             << "3. Количество пациентов, возраст которых находится в заданном интервале\n"
             << "4. Выход\n";

        int choice = user_prompt(1, 4);

        switch (choice)
        {
        case 1:
            try
            {
                find_diagnosis(people, 10);
            }
            catch(const NotFoundException& e)
            {
                std::cout << e.what();
            }
            break;

        case 2:
            try
            {
                find_number_in_interval(people, 10);
            }
            catch(const IncorrectDataException& e)
            {
                std::cout << e.what();
            }
            break;
        
        case 3:
            try
            {
                find_year_in_interval(people, 10);
            }
            catch(const IncorrectDataException& e)
            {
                std::cout << e.what();
            }
            break;

        default:
            return 0;
            break;
        }

    } while (true);

}


int user_prompt(int from, int to)
{
	int tmp = 0;
	do
	{
		cin >> tmp;
	}
	while (tmp < from || tmp > to);
	return tmp;
}


void find_diagnosis(Patient * arr, int n)
{
    bool found = false;
    string diagn;
    cout << "Введите диагноз (от а до е): ";
    cin >> diagn;

    cout << "Результаты поиска:\n";

    for (int i = 0; i < n; i++)
    {
        if (arr[i].diagnosis == diagn) {
            found = true;
            arr[i].print();
        }
    }
    
    if (!found)
        throw NotFoundException();
}


void find_number_in_interval(Patient * arr, int n)
{
    int start, end;

    cout << "Введите начало интервала:\n";
    start = user_prompt(0, INT_MAX);
    cout << "Введите конец интервала:\n";
    end = user_prompt(0, INT_MAX);

    if (start > end)
        throw IncorrectDataException();
    else 
        for (int i = 0; i < n; i++)
            if (arr[i].number >= start && arr[i].number <= end)
                arr[i].print();

}


void find_year_in_interval(Patient * arr, int n)
{
    int start, end;

    cout << "Введите год начала интервала:\n";
    start = user_prompt(0, INT_MAX);
    cout << "Введите год конца интервала:\n";
    end = user_prompt(0, INT_MAX);

    if (start > end)
        throw IncorrectDataException();
    else 
        for (int i = 0; i < n; i++)
            if (arr[i].year >= start && arr[i].year <= end)
                arr[i].print();

}


void fill(Patient * people, int n)
{
    string last_names[10] = {"Иванов", "Смирнов", "Кузнецов", "Попов", "Васильев", "Петров", "Соколов", "Михайлов", "Новиков", "Фёдоров"};
    string fisrt_names[10] = {"Андрей", "Сергей", "Дмитрий", "Юрий", "Ярослав", "Денис", "Иван", "Михаил", "Алексей", "Александр"};
    string father_names[10] = {"Андреевич", "Сергеевич", "Дмитриевич", "Юриьевич", "Ярославович", "Денисович", "Иванович", "Михайлович", "Алексеевич", "Александрович"};
    string diag[5] = {"a", "b", "c", "d", "e"};

    srand(time(nullptr));

    for (int i = 0; i < n; i++)
    {
        people[i].firstName = fisrt_names[rand() % 10];
        people[i].lastName = last_names[rand() % 10];
        people[i].fatherName = father_names[rand() % 10];
        people[i].diagnosis = diag[rand() % 5];
        people[i].year = rand() % 60 + 1950;
        people[i].number = rand() % 10000;
    }
}