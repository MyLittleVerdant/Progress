#include <iostream> 
#include <sstream> 
#include <map> 
#include <fstream>
#include <ctime>
#include <chrono>

using namespace std;

/*int main() {
	multimap< char, int > text;
	string line;

	
		
		cin >> line;
		if (line.empty()) return 0;
		istringstream ist(line);
		char let;
		while ((let = ist.get()) && let != EOF)
			text.insert(pair< char, int >(let, 1));
		
	

	

		char k = 'k',K='K';
		cout << k << "(" << text.count(k) << ") " << endl << K << "(" << text.count(K) << ") " << endl;
	

}*/

//1 mls=1000mcs
int findk()
{
	chrono::time_point<std::chrono::system_clock> start, end;
	start = chrono::system_clock::now();
	ifstream file("file.txt");
	string line;
	int count = 0;

	if (file)
	{
		while (!file.eof())
		{

			file >> line;
			if ((line[0] == 'K') || (line[0] == 'k') || (line[0] == 'К') || (line[0] == 'к'))
				count++;
			

		}
	}
	else
		cout << "File not found" << endl;

	file.close();
	end = std::chrono::system_clock::now(); int time = chrono::duration_cast<std::chrono::microseconds>(end - start).count();
	cout << "Время выполнения функции " << time << " микросекунд" << endl;
	return count;
}
int findw()
{
	chrono::time_point<std::chrono::system_clock> start, end;
	start = chrono::system_clock::now();
	ifstream file("file.txt");
	string line;
	string word;
	int count = 0;
	cout << "Word to find: ";
	cin >> word;

	if (file)
	{
		while (!file.eof())
		{

			file >> line;
			if (line==word)
				count++;
			

		}
	}
	else
		cout << "File not found" << endl;

	file.close();
	end = std::chrono::system_clock::now(); int time = chrono::duration_cast<std::chrono::seconds>(end - start).count();
	cout << "Время выполнения функции " << time << " секунд(ы)" << endl;
	return count;
}

void main()
{
	setlocale(LC_ALL, "rus");
	string choice;
	int choice1;
	bool exit = false;
	
	
	
	cout << "Выберите задание:"<<endl<<"1.Определить сколько слов начинается на букву К или к"<<endl<<"2.Определить сколько раз в тексте встречается заданное слово"<<endl<<"5.Выход"<<endl;
	do
	{
		cin >> choice;
		if (choice != "1" && choice != "2" && choice != "5")
			cout << "Такого задания не найдено" << endl;
		choice1 = atoi(choice.c_str());
		switch (choice1)
		{
		case 1:cout << "Найдено слов: "<<findk() << endl;  break;
		case 2:cout << "Найдено слов: " <<findw() << endl; break;
		case 5:exit = true; break;
		}

	} while (!exit);
	
}