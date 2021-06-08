#include<iostream>
#include <vector>
#include <fstream>
#include <string>
#include <iterator>
#include <typeinfo>
using namespace std;


class faculty
{

public:
	virtual void FavSpell() = 0;
	
};

class Gryffindor:public faculty
{
protected:
	unsigned int sizeG=0;
public:
	Gryffindor(){}
	void incGr()
	{
		sizeG++;
	}
	unsigned int Size()
	{
		cout << sizeG<<" students study in the Gryffindor"<<endl;
		return sizeG;
	}

	void FavSpell() override
	{
		cout << "Expecto Patronum!" << endl;
	}
};


class Hufflepuff :public faculty
{
	unsigned int sizeH = 0;
public:
	Hufflepuff(){}
	void incH()
	{
		sizeH++;
	}
	unsigned int Size()
	{
		cout << sizeH << " students study in the Hufflepuff" << endl;
		return sizeH;
	}

	void FavSpell() override
	{

		cout << "Enervate!" << endl;
	}
};


class Ravenclaw :public faculty
{
	unsigned int sizeR = 0;
public:
	Ravenclaw(){}
	void incR()
	{
		sizeR++;
	}
	unsigned int Size()
	{
		cout << sizeR << " students study in the Ravenclaw" << endl;
		return sizeR;
	}

	void FavSpell() override
	{
		cout << "Impedimenta!" << endl;
	}
};

class Slytherin :public faculty
{
	unsigned int sizeS = 0;
public:
	Slytherin(){}
	void incS()
	{
		sizeS++;
	}
	unsigned int Size()
	{
		cout << sizeS << " students study in the Slytherin" << endl;
		return sizeS;
	}


	void FavSpell() override
	{
		cout << "Crucio!" << endl;
	}
};



/*class student
{
	string name;
	string fac;
public:
	friend ostream& operator<< (ostream& out, const student& Hogwarts);
	friend Gryffindor;
	student()
	{

	}

	void FavSpell(faculty* fac)
	{
		fac->FavSpell();
	}

	student(vector <student>& Hogwarts, Gryffindor &Gryffindor, Hufflepuff &Hufflepuff, Ravenclaw &Ravenclaw, Slytherin &Slytherin)
	{
		ifstream file("file.txt");
		string Name,Soname, Fac,line;
		
		if (file)
		{
			while (!file.eof())
			{
				student temp;
				file >> Name >> Soname >> Fac;
				
				
				temp.name = Name;
				temp.name += " ";
				temp.name += Soname;
				temp.fac = Fac;
				if (Fac == "Gryffindor")
					Gryffindor.incGr();
				else if (Fac == "Hufflepuff")
					Hufflepuff.incH();
				else if (Fac == "Ravenclaw")
					Ravenclaw.incR();
				else
					Slytherin.incS();
				Hogwarts.push_back(temp);


			}
		}
		else
			cout << "File not found" << endl;

		file.close();
	}

	void output(const vector <student> Hogwarts)
	{
		for (auto iter = Hogwarts.begin(); iter != Hogwarts.end(); iter++)
		{
			cout << *iter;
		}
	}
};
ostream& operator <<(ostream& out,  const student & Hogwarts)
{

	out << Hogwarts.name << " "<< Hogwarts.fac<<endl<<endl;

	return out;
}*/


void main()
{
	Gryffindor Gr;
	Hufflepuff H;
	Ravenclaw R;
	Slytherin S;
	faculty* Ar[10];
	Ar[0] = new Gryffindor();
	Ar[1] = new Gryffindor();
	Ar[2] = new Hufflepuff();
	Ar[3] = new Hufflepuff();
	Ar[4] = new Ravenclaw();
	Ar[5] = new Ravenclaw();
	Ar[6] = new Slytherin();
	Ar[7] = new Slytherin();
	Ar[8] = new Gryffindor();
	Ar[9] = new Ravenclaw();
	for (int i = 0; i < 10; i++)
	{	
		if (typeid(*Ar[i]) == typeid(Gryffindor))
			Gr.incGr();
		else if (typeid(*Ar[i]) == typeid(Hufflepuff))
			H.incH();
		else if (typeid(*Ar[i]) == typeid(Ravenclaw))
			R.incR();
		else S.incS();
	}
	Gr.Size();
	H.Size();
	R.Size();
	S.Size();

	Ar[0]->FavSpell();
	Ar[2]->FavSpell();
	Ar[4]->FavSpell();
	Ar[6]->FavSpell();
	//vector <student> Hogwarts;
	//student students(Hogwarts, Gryffindor, Hufflepuff, Ravenclaw, Slytherin);
	//students.output(Hogwarts);
	//Gryffindor.Size();
	
	

}