#include <iostream>
#include <vector>
#include <ctime>
using namespace std;

class coin
{
public:
	int weight;
	int pos;
};
int compare(int a,int  b)
{
	if (a > b)
		return 1;
	else if (a < b)
		return 2;
	else if (a == b)
		return 3;
}

int search(vector <coin >& a)
{
	int result=0;
	int sum1=0, sum2=0;
	if (a.size() % 2 == 0)
	{
		if ( a.size() > 2)
		{
			for (int i = 0; i < a.size() / 2; i++)
			{
				sum1 += a[i].weight;

			}
			for (int i = a.size() / 2; i < a.size() ; i++)
			{
				sum2 += a[i].weight;

			}
		}
		else
		{
			result = compare(a[0].weight, a[1].weight);
			if (result == 1)
				return a[1].pos;
			else if (result == 2)
				return a[0].pos;
			else
				return -1;
		}

		result = compare(sum1, sum2);
		if (result == 1)
		{
			auto begin = a.begin();
			auto end = a.end();
			a.erase(begin, end- a.size()/2);
			return search(a);
		}
		else if (result == 2)
		{
			auto begin = a.begin();
			auto end = a.end();
			a.erase(begin+ a.size() / 2, end );
			return search(a);
		}
		else if (result == 3)
			return -1;
	}
	else if (a.size() % 2 != 0)
	{
		if (a.size() == 1)
		{
			cout << "Невозможно определить" << endl;
			return -2;
		}
		else
		{
			result = compare(a[a.size() - 2].weight, a[a.size() - 1].weight);
			if (result == 3)
				a.pop_back();
			else if (result == 1)
				return a[a.size() - 1].pos;
			else if (result == 2)
				return a[a.size() - 2].pos;
			return search(a);
		}
	}

}
void main()
{
	setlocale(LC_ALL, "rus");
	srand(time(0));
	int n, found;
	cout << "Введите количество монет "  ;
	cin >> n;
	int fake;
	fake = rand()%n;
	vector <coin> a(n);
	int weight = 2, Fweight = 1;
	for (int i = 0; i < n;i++)
	{
		if (i == fake)
		{
			a[i].weight = Fweight;
			a[i].pos = i;
		}
		else
		{
			a[i].weight = weight;
			a[i].pos = i;
		}
			
	}
	found = search(a);
	if (found == -1)
		cout << "Фальшивой монеты нет" << endl;
	else if (found>-1)
	cout << "Фальшивая монета лежит на позиции " << fake << endl << "Результат алгоритма " << found << endl;
}