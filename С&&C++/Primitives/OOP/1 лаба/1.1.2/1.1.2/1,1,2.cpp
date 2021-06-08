#define _CRT_SECURE_NO_WARNINGS
#include <iostream>
#include <fstream>
#include <string>
#include <vector>
#include <algorithm>
using namespace std;

void output(vector<int> & collection)
{
	
	for (size_t i= 0; i < collection.size(); ++i)
		cout << collection[i] << " ";
}

void random(vector<int>& collection,int N)
{
	int A, B;

	cout << "Enter an interval A-B: ";
	cin >> A >> B;
	if (A > B)
	{
		A = A + B;
		B = A - B;
		A = A - B;
	}
	for (int i = 0; i <N; i++)
	    collection.push_back(rand() % (B-A+1)+ A);
	
		
}

void handswork(vector<int>& collection,int N)
{
	int tmp;
	for (int i = 0; i < N; i++)
	{
		cin >> tmp;
		collection.push_back(tmp);
	}
		
}

void fromfile(vector<int>& collection, int N)
{
	int i = 0,tmp;
	char name[20], buff[50];
	cout << "Enter the name and extension of the file to read " << endl;
	cin >> name;
	ifstream file(name);
	if (file)
	{
		while (i != N)
		{

			file >> buff;
			tmp= atoi(buff);
			collection.push_back(tmp);
			i++;


		}

	}
	else cout << " File not exist" << endl;
	file.close();
}


void turn1(vector<int>& collection)
{
	int mid = collection.size() / 2;
	int temp;
	for (int  i = 0; i < mid; i++)
	{
		temp = collection[i];
		collection[i] = collection[collection.size() - i - 1];
		collection[collection.size() - i - 1] = temp;
	}
}

void find6(vector<int>& collection)
{
	int maxeven = INT_MIN, minodd = INT_MAX, m1 = 0, m2 = 0, temp;
	for (size_t i = 0; i < collection.size(); i++)
	{
		if (collection[i] > maxeven && collection[i] % 2 == 0)
		{
			maxeven = collection[i];
			m1 = i;
		}
		if (collection[i] < minodd && collection[i] % 2 == 1)
		{
			minodd = collection[i];
			m2 = i;
		}
	}
	if (maxeven != INT_MIN && minodd != INT_MAX)
	{
		temp = collection[m1];
		collection[m1] = collection[m2];
		collection[m2] = temp;
	}
	else
		for (size_t i = 0; i < collection.size(); i++)
			collection[i] = 0;


}

void mtt16(vector<int>& collection)
{
	int a[10] = { 0 }, i, n, l = 0;
	for (size_t e = 0; e < collection.size(); e++)
	{
		if (collection[e] / 1000 > 0)
		{
			n = collection[e];
			while (n > 0)
			{
				i = n % 10;
				a[i]++;
				n /= 10;
			}
			for (i = 0; i < 10; i++)
				if (a[i] > 0) l++;
			for (i = 0; i < 10; i++)
				a[i] = 0;
			if (l > 3)
			{
				collection.erase(collection.begin() + e);
				l = 0;
				e--;
			}
		}
	}
}

void savefile(vector<int>& collection)
{
	ofstream file("save.txt");
	string s_str;
	for (size_t i = 0; i < collection.size(); i++)
	{
		s_str += to_string(collection[i]);
		s_str += " ";
	}
	file << s_str;
	file.close();
}
void deleven11(vector<int>& collection)
{
	for (size_t i = 0; i < collection.size(); ++i)
		if (collection[i] % 2 == 0)
		{
			collection.erase(collection.begin() + i);
			i--;
		}
			

}

void main()
{
	int N,c,num;
	vector <int> collection;
	bool exit = false;
	do {
		cout << "Enter quantity of elements: ";
		cin >> N;
	} while (N < 1);
	collection.reserve(N);
	cout << "How to fill the array?" << endl << "1.Random" << endl << "2.Myself" << endl << "3.From file" << endl;
	do {
		cin >> c;
		if (c < 1 || c>3)
			cout << "Incorrect choise.Try again"<<endl;
	} while (c < 1 || c>3);
	cout << endl;
	switch (c)
	{
	case 1:random(collection,N); output(collection); cout << endl; break;
	case 2:handswork(collection,N); break;
	case 3:fromfile(collection, N); break;
	}
	do {
		cout << "Enter 5 for an exit." << endl << "Choose number of a task: ";
		cin >> num;
		switch (num)
		{
		case 1:turn1(collection); output(collection); savefile(collection); cout << endl; break;
		case 5:exit = true; break;
		case 6:find6(collection); output(collection); savefile(collection); cout << endl; break;
		case 11:deleven11(collection); output(collection); savefile(collection); cout << endl; break;
		case 16:mtt16(collection); output(collection); savefile(collection); cout << endl; break;
		};
		cout << endl;

	} while (!exit);
}