#include"Header.h"
#include "Aeroflot.h"
#include "List.h"
#include "VList.h"


using namespace std;

bool is_number(const string& s)
{
	bool flag = false;
	if (s[0] >= '0' && s[0] <= '9')
		flag=true;
	return flag;
}
void FromFile(VList<float>& MLV)
{
	ifstream file("Num.txt");
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

	int k,c;
	string type;
	cout << "Enter a VList data type: ";
	do {
		cin >> type;
	} while (type != "float" && type != "custom");
	if (type == "float")
	{
		VList<float> MLV;
		do {
			cout << "1.To fill out the list from file:"  << endl << "2.To fill out the list from on your own" << endl <<"3.Find Min"<<endl<<"4.Delete element" <<endl<<"5.Exit" << endl<<endl;
			do {
				cin >> k;
			} while (k < 1 && k>2);
			string num;
			switch (k)
			{
			case 1:FromFile(MLV);
				cout << "List:" << endl << MLV << endl; break;
			case 2:
				float number;
				do {
					cout << "1.AddToEnd" << endl << "2.AddToBeg" << endl << "3.AddAft" << endl << "4.Exit" << endl;
					do {
						cin >> c;
					} while (c < 1 && c>3);
					switch (c)
					{
					case 1:cout << "Enter not a number to exit" << endl;
						do {
							cin >> num;
							if (is_number(num))
							{
								number = stof(num.c_str());
								MLV.AddToEnd(number);
							}
						} while (is_number(num));
						cout << "List:" << endl << MLV << endl; break;
					case 2:cout << "Enter not a number to exit" << endl;
						do {
							cin >> num;
							if (is_number(num))
							{
								number = stof(num.c_str());
								MLV.AddToBeg(number);
							}
						} while (is_number(num));
						cout << "List:" << endl << MLV << endl; break;
					case 3:int pos;
						cout << "Enter not a number to exit" << endl;
						do {
							cin >> num;
							if (is_number(num))
							{
								number = stof(num.c_str());
								cout << "Enter the position after which you want to insert a number:";
								cin >> pos;
								MLV.AddAft(number, pos);
							}
						} while (is_number(num));
						cout << "List:" << endl << MLV << endl; break;
					}
				} while (c != 4); break;
			case 3:if (MLV.getCount())
			{
				float min;
				min = MLV.min();
				cout << "Min= " << min << endl << endl;
			}break;
			case 4:if (MLV.getCount())
			{
				int pos;
				cout << "Enter the position you want to delete:";
				cin >> pos;
				MLV.del(pos);
				cout << "List:" << endl << MLV << endl; break;
			}break;


			}
			
			
		} while (k != 5);
	}
	else
	{
		
		List<VList<Aeroflot>> MLV;
		do {
			cout << "To fill out the list from:" << endl << "1.File" << endl << "2.On your own"<<endl <<"3.Exit"<< endl;
			do {
				cin >> k;
			} while (k < 1 || k>3);



			if (k == 1)
			{
				VList<Aeroflot> temp;
				temp.fill("file.txt");
				MLV.AddToEnd(temp);

				temp.clear();
				temp.fill("file1.txt");
				MLV.AddToEnd(temp);
				temp.clear();
				cout << "List:"<<endl << MLV << endl;



			}
			else if(k==2)
			{
				List<VList<Aeroflot>> MLV;
				VList<Aeroflot> tempList;
				Aeroflot temp;
				int n;
				do {
					cout << "Negative number for exit" << endl << "Enter number of flight: ";
					cin >> n;

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

					}

					tempList.AddToEnd(temp);
					MLV.AddToEnd(tempList);
					tempList.clear();

				} while (n > 0);
				cout << "List:" << endl << MLV << endl;
			}
		} while (k != 3);
	}



}



















/*void main()
{
	//VList<List<Aeroflot>> test;
	//List<Aeroflot> temp;

	List<VList<Aeroflot>>test;
	VList<Aeroflot> temp;
	temp.fill("file.txt");
	test.AddToEnd(temp);
	cout << test;

	//test.Show();
}*/