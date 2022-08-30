#include<iostream>
#include <vector>
#include <list>
#include <iterator>
using namespace std;


int Hash(string key,int m)
{
	int temp = 0;
	for (int i = 0; i < key.size(); i++)
	{
		temp += key[i];
	}
	temp %= m;
	return temp;
}

int Add(vector <list <string>> &table,string key,int hash)
{
	int compares = 0;
	for (int i = 0; i < table.size(); i++)
	{
		compares++;
		if(hash==i)
		{
			table[i].push_back(key);
			cout  << "���� ��������� " << compares << " ���������(��)" << endl<<endl;
			return 1;
		}
		
	}
	return 0;
}
int del(vector <list <string>>& table, string key)
{
	
	for (int i = 0; i < table.size(); i++)
	{
			
			auto begin = table[i].begin();
			auto end = table[i].end();

			for (begin; begin != end; begin++) {
				if (*begin == key)
				{
					table[i].erase(begin);
					return 1;
				}
			}


	}
	return 0;
}
int find(vector <list <string>>& table, string key)
{
	int compares = 0;
	bool flag = false, find = false;
	for (int i = 0; i < table.size(); i++)
	{
		
			auto begin = table[i].begin();
			auto end = table[i].end();

			for (begin; begin != end; begin++) {
				compares++;
				if (*begin == key)
				{
					cout << "���: " << i << "   " << "����:  " <<*begin<< endl;
					cout << "���� ��������� " << compares << " ���������(��)" << endl<<endl;
					
				}
			}
		
		if (find)
			flag = true;
		if(flag)
		    return 1;


	}
	return 0;
}
void output(vector <list <string>> table)
{
	for (int i = 0; i < table.size(); i++)
	{
		cout << "���: " << i <<"   "<< "����(�):  ";
		
		auto begin = table[i].begin();
		auto end = table[i].end();
		for (begin;begin!= end; begin++) {
			cout << (*begin) << " ";
		}
		
		cout << endl;
	}
}

int main()
{
	setlocale(LC_ALL,"rus");
	int m,n;
	string key;
	cout << "������� ������ ������� ";
	cin >> m;
	vector <list <string>> table(m);
	do{
		cout << endl << "0.�����" << endl << "1.�������� ��������" << endl << "2.������� �������" << endl << "3.������� ������� �� �����" << endl << "4.����� �����" << endl;
		cin >> n;
		if (n > -1 && n < 5)
		{
			cout << endl;
			switch (n)
			{
			case 0:return 1;
			case 1: {cout << "������� end() ��� ���������� �����" << endl;
				do
				{
					cout << endl << "������� ����: ";
					cin >> key;
					if (key != "end()")
						Add(table, key, Hash(key, m));
				} while (key != "end()"); break; }

			case 2:output(table); break;
			case 3: {
				cout << "������� ���� ��� ��������: ";
				cin >> key;
				del(table, key); break;
			}
			case 4: {
				cout << "������� ���� ��� ������: ";
				cin >> key;
				cout << endl;
				find(table, key); break; }
			}
		}
		else
			cout << "����� ������� �� ����������" << endl;
		
	} while (true);
	
	

	
}