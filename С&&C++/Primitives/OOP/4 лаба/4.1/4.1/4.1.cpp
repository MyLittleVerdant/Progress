#include <iostream>
using namespace std;

class human
{
protected:
	string name;
	int age;
	string education;

public:
	friend ostream& operator<< (ostream& out, const human&man);
	human()
	{

	}
	human (string name,int age,string education)
	{
		this->name = name;
		this->age = age;
		this->education = education;
	}

	~human()
	{

	}

	void renominate()
	{
		string educ;
		cout << "education:";
		cin >>educ;
		this->education = educ;
		cout << endl;
	}

};
class employee:public human
{
	string speciality;

public:
	friend ostream& operator<< (ostream& out, const employee& worker);
	employee (string name, int age, string education, string speciality)
	{
		this->name = name;
		this->age = age;
		this->education = education;
		this->speciality = speciality;
	}
	void reassignment()
	{
		string spec;
		cout << "speciality:";
		cin >> spec;
		this->speciality = spec;
		cout << endl;
	}
};
ostream& operator <<(ostream& out, const human& man)
{

	out << man.name << " " << man.age << " " << man.education << endl;

	return out;
}
ostream& operator <<(ostream& out, const  employee& worker)
{

	out << worker.name << " " << worker.age << " " << worker.education <<" "<< worker.speciality<< endl;

	return out;
}

void main()
{
	int c;
	human man1("Artem", 19, "None");
	human *man2=new human("Max", 20, "None");
	employee worker1("John", 26, "bachelor", "programmer");

	cout << man1 << *man2 <<worker1<< endl<<endl;
	do {
		cout << "Access: ";
		cin >> c;
		switch (c)
		{
		case 1:man1.renominate(); break;
		case 2:man2->renominate(); break;
		case 3:worker1.renominate(); break;
		}
		cout << man1 << *man2 << worker1 << endl << endl;
	} while (c != 5);

	worker1.reassignment();
	cout << man1 << *man2 << worker1 << endl;

	delete man2;
}