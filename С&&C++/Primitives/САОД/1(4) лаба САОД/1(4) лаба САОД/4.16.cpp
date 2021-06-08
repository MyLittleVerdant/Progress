#include <iostream>
using namespace std;

int main()
{
	setlocale(LC_ALL, "rus");
	int* a = new int[5];
	for (int i = 0; i < 5; i++)
	{
		cout << "¬ведите " << i+1 << "-ое число: ";
		cin >> a[i];
		cout << endl;
	}
	if (a[0] > a[4])//1
	{
		a[0] += a[4];
		a[4] = a[0] - a[4];
		a[0] -= a[4];
	}
	if (a[1] > a[3])//2
	{
		a[1] += a[3];
		a[3] = a[1] - a[3];
		a[1] -= a[3];
	}
	if (a[0] > a[1])//3
	{
		a[0] += a[1];
		a[2] = a[0] - a[1];
		a[0] -= a[1];

		a[3] += a[4];
		a[4] = a[3] - a[4];
		a[3] -= a[4];
	}
	if (a[1] > a[2])//4
	{
		int temp=a[2];
		a[2] = a[1];
		if (temp < a[0])//5
		{
			a[1] = a[0]; a[0]= temp;
		}
		else a[1] = temp;//5
	}
	else if (a[3] < a[2])//5
	{
		a[3] += a[2];
		a[2] = a[3] - a[2];
		a[3] -= a[2];
	}
	if (a[4] < a[2])//6
	{
		int temp = a[4];
	    a[4] = a[3]; a[3] = a[2];
	 if (temp < a[1])//7
	 {
		 a[2] = a[1]; a[1] = temp;
	 }
		else a[2] = temp;//7
	}
	else if (a[4] < a[3])//7
	{
		a[3] += a[4];
		a[4] = a[3] - a[4];
		a[3] -= a[4];
	}
	
	cout<<endl << "–езультат сортировки по возрастанию: ";
	for (int i = 0; i < 5; i++)
	{
		cout<< a[i]<<"  ";

	}
	cout << endl << endl;
}