#include <iostream>
#include <map>
#include <fstream>
using namespace std;

class payment
{
	string data;
	string type;
	double sum;
	string sender;
	string reciever;

public:
	friend ostream& operator<< (ostream& out, const payment& second);
	payment()
	{}
	payment(multimap< string, payment > &bills)
	{
		string data;
		string type;
		double sum;
		string sender;
		string reciever;
		ifstream file("file.txt");

		if (file)
		{
			while (!file.eof())
			{

				file >> data >> type>> sum>> sender>> reciever;
				payment temp;
				temp.data = data; temp.type= type; temp.reciever = reciever; temp.sender = sender; temp.sum= sum;
				bills.insert(make_pair(type, temp));


			}
		}
		else
			cout << "File not found" << endl;

		file.close();
	}
	void output( const multimap< string, payment >& bills)
	{
		
		for (auto it = bills.begin(); it != bills.end(); it++) {  // выводим их
			cout<<it->second << endl;
		}
	}
	void findout(const multimap< string, payment >& bills)
	{
		string temp;
		do {
			cout << "Typeof payment: ";
			cin >> temp;
			int t = bills.count(temp);
			if (t == 0&&temp!="5")
				cout << "There are no payments of this type" << endl;
			else if(t>0)cout << t << endl;
		} while (temp != "5");
	}
	void max(const multimap< string, payment >& bills)
	{
		auto it1 = bills.find("credit");
		auto it2 = bills.find("utility");
		auto it3 = bills.find("mobile");
		for (auto it = bills.begin(); it != bills.end(); it++) {  // выводим их
			if (it1->first == it->first && it1->second.sum < it->second.sum)
				it1 = it;
			if (it2->first == it->first && it2->second.sum < it->second.sum)
				it2 = it;
			if (it3->first == it->first && it3->second.sum < it->second.sum)
				it3 = it;
		}
		cout <<"Maximum payments of each type: "<<endl<< it1->second  << it2->second  << it3->second << endl;
	}
};
ostream& operator<< (ostream& out, const payment&second)
{
	
	out << second.data << " " << second.type << " " << second.sum<<" "<<second.sender << " " <<second.reciever<< endl;

	return out;
}
void main()
{
	multimap< string, payment > bills;
	payment payment(bills);
	payment.output(bills);
	payment.max(bills);
	payment.findout(bills);

}