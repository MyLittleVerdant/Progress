#include <iostream>
#include <list>     // подключаем заголовок списка
#include <iterator> // заголовок итераторов
#include <fstream>
using namespace std;


class parcel {
	string name;
	string date;
	string reciever;
	string sender;
	double weight;
	double price;

public:
	friend ostream& operator<< (ostream& out, const parcel& box);
	parcel()
	{

	}
	/*void copy(string name, string date, string reciever, string sender, double weight,double price)
	{
		this->name= name;
		this->date= date;
		this->reciever= reciever;
		this->sender= sender;
		this->weight = weight;
		this->price = price;


	}*/
	parcel(list<parcel> &box)
	{
		string name;
		string date;
		string reciever;
		string sender;
		double weight;
		double price;
		ifstream file("file.txt");

		if (file)
		{
			while (!file.eof())
			{

				file >> name >> date >> reciever >> sender >> weight >> price;
				parcel temp;
				temp.name = name; temp.date = date; temp.reciever = reciever; temp.sender = sender; temp.weight = weight; temp.price = price;
				box.push_back(temp);


			}
		}
		else
			cout << "File not found" << endl;

		file.close();
	}
	

	void output(list<parcel> box)
	{
		for (auto iter = box.begin(); iter != box.end(); iter++)
		{
			cout << *iter ;
			
		}
	}

	void avg(double &kg, double &uah, list<parcel>& box)
	{
		parcel temp;
		int size = box.size();
		for (auto iter = box.begin(); iter != box.end(); iter++)
		{
			temp = *iter;
			kg += temp.weight;
			uah += temp.price;

		}
		kg = kg / size;
		uah = uah / size;
	}
	void compare(list<parcel>& box)
	{
		string reciever;
		bool flag=false;
		do {
			cout << "Reciever: ";
			cin >> reciever;

			parcel temp;
			for (auto iter = box.begin(); iter != box.end(); iter++)
			{
				temp = *iter;
				if (temp.reciever == reciever)
				{
					cout << temp;
					flag = true;
				}
			}
			if (flag == false)
				cout << "The reciever not found" << endl;
			
		} while (reciever!="5");
		
	}
};
ostream& operator <<(ostream& out, const parcel& box)
{

	out << box.name << " " << box.date << " " << box.reciever << " " << box.sender << " " << box.weight << " " << box.price << endl;

	return out;
}

void main()
{
	double kg=0, uah=0;
	list<parcel> box;
	parcel parcel(box);
	parcel.output(box);
	cout << fixed;
	cout.precision(2);
	parcel.avg(kg, uah,box);
	cout <<endl<< "Average weight: "<<kg << endl <<"Average price: "<< uah << endl;
	parcel.compare(box);

}