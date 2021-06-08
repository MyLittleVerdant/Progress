#include <iostream>
#include <fstream>
using namespace std;


string ReadC(ifstream &filec)
{
	string temp;
	
	
	filec >> temp;
	
	
	return temp;

}
string ReadD(ifstream& filed)
{
	string temp;
	
	

	filed >> temp;


	return temp;

}

int Compare(string  c,string  d,int &count)
{
	count++;
	int a, b;
	a = atoi(c.c_str());
	b = atoi(d.c_str());
	if (a > b)
		return 1;
	else return 2;
}

void main()
{
	setlocale(LC_ALL, "rus");
	int count = 0,compare=0;
	bool readc = false,readd = false;
	string tempc, tempd;
	int numc, numd,bitc=0,bitd=0;
	ifstream filec;
	filec.open("c.txt", filec.binary);
	ifstream filed;
	filed.open("d.txt", filed.binary);
	ofstream filef("f.txt");
	tempc = ReadC(filec);
	tempd = ReadD(filed);
	if (filec && filed)
	{
		while (tempc!=""&& tempd!="")
		{
			if (readc)
			{
				tempc = ReadC(filec);
				
					
				readc = false;
			}
			if (readd)
			{
				tempd = ReadD(filed);
				readd = false;
			}
			compare = Compare(tempc, tempd, count);
			if (compare == 1)
			{
				filef << tempc << " ";
				numc = atoi(tempc.c_str());
				if (numc > 9)
					bitc += 3;
				else
					bitc += 2;
				filec.seekg(bitc, filec.beg);
				readc = true;
			}
			else if (compare == 2)
			{
				filef << tempd<<" ";
				numd = atoi(tempd.c_str());
				if (numd > 9)
					bitd += 3;
				else
					bitd += 2;
				filed.seekg(bitd, filed.beg);
				readd = true;
			}
		}
		if (filec.eof())
		{
			while (!filed.eof())
			{
				tempd= ReadD(filed);
				filef << tempd;
			}
		}
		else if (filed.eof())
		{
			while (!filec.eof())
			{
				tempc = ReadC(filec);
				filef << tempc;
			}
		}

	}
	

	cout <<"Число сравнений равно " <<count<<endl;

	//cout << ReadC(filec, bitc);
	filec.close();
	filed.close();
	filef.close();
}