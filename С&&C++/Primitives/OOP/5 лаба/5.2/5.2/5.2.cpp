#include "vlist.h"
#include "List.h"
#include <fstream>

using namespace std;

bool is_number(const string& s)
{
	return !s.empty() && (s.find_first_not_of("0123456789") == s.npos);
}
void FromFile(VList<float> &MLV )
{
	ifstream file("Num");
	float Num;
	if (file)
	{
		while (!file.eof())
		{

			file >> Num;

			MLV.AddToEnd(Num);



		}
	}
	else
		cout << "File not found" << endl;

	file.close();

}


void main()
{
	
	int k;
	string type;
	cout << "Enter a VList data type: ";
	do {
		cin >> type;
	} while (type != "float" && type != "custom");
	if (type == "float")
	{
		VList<float> MLV;
		cout << "To fill out the list from:" << endl << "1.File" << endl << "2.On your own" << endl;
		do {
			cin >> k;
		} while (k < 1 && k>2);


		if (k == 1)
		{
			FromFile(MLV);
		}
		else
		{
			string num;
			float number;
			do {
				cin >> num;
				if (is_number(num))
				{
					number = atoi(num.c_str());
					MLV.AddToEnd(number);
				}
			} while (is_number(num));

		}
	}
	else
	{
		VList<List> MLV;
		cout << "To fill out the list from:" << endl << "1.File" << endl << "2.On your own" << endl;
		do {
			cin >> k;
		} while (k < 1 || k>2);



		if (k == 1)
		{
			List temp;
			temp.fill("file.txt");
			MLV.AddToEnd(temp);
			temp.clear();
			temp.fill("file1.txt");
			MLV.AddToEnd(temp);
			temp.clear();
		//	MLV.Show();
			

		}
		else
		{
			int n;
			cout << "Enter number of flight: ";
			cin >> n;
			Aeroflot temp;
			for (int i = 0; i < n; i++)
			{
				cout << "Destination: ";
				cin >> temp.destination;
				cout << "Num: ";
				cin >> temp.num;
				cout << "Time: ";
				cin >> temp.time;
				cout << "Type: ";
				cin >> temp.type;
				cout << "Date: ";
				cin >> temp.date;
				//MLV.getData().Add(temp);
			}

		}
	}



}



/*struct my_type
{
	int x;
	double y;
};

VList<my_type> my_list; //Пример использования списка с типом, определенным пользователем
void main()
{
	my_type* point = new my_type;
	for (int i = 1; i <= 5; i++)
	{
		
		point->x = i;
		point->y = i + 0.2;
		my_list.AddToEnd(*point);
	}

	cout << endl << my_list.getCount() << endl;
	for (int i = 1; i <= my_list.getCount(); i++)
		cout << my_list.getData(i).x << " " << my_list.getData(i).y << endl;

	my_list.clear();

	for (int i = 1; i <= 5; i++)
	{
		
		point->x = i;
		point->y = i + 0.2;
		my_list.AddToBeg(*point);
	}

	cout << endl << my_list.getCount() << endl;
	for (int i = 1; i <= my_list.getCount(); i++)
		cout << my_list.getData(i).x << " " << my_list.getData(i).y << endl;

	point->x = 999;
	point->y = 999 + 0.2;

	my_list.AddAft(*point,3);

	cout << endl << my_list.getCount() << endl;
	for (int i = 1; i <= my_list.getCount(); i++)
		cout << my_list.getData(i).x << " " << my_list.getData(i).y << endl;


	my_list.clear();
	
}*/