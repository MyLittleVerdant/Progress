#define _CRT_SECURE_NO_WARNINGS
#include <iostream>
#include <fstream>
#include <string>
#include <memory>
using namespace std;

void random(unique_ptr<double[]> &array, int N)
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
	for (int i = 0; i < N; i++)

		array[i] = rand() % B + A;
}

void handswork(unique_ptr<double[]> &array, int N )
{
	for (int i = 0; i < N; i++)
		cin >> array[i];
	cout << endl;
}

void output(unique_ptr<double[]>& array, int N)
{
	for (int i = 0; i < N; i++)
		cout << array[i] << " ";
}

void main()
{
	int N, c, Sumev = 0, Sumodd = 0;
	double gavg = 1;
	bool exit = false;
	do {
		cout << "Enter quantity of elements: ";
		cin >> N;
	} while (N < 1);
	unique_ptr<double []> array(new double[N]);
	cout << "How to fill the array?" << endl << "1.Random" << endl << "2.Myself"  << endl;
	do {
		cin >> c;
		if (c < 1 || c>3)
			cout << "Incorrect choise.Try again" << endl;
	} while (c < 1 || c>3);
	switch (c)
	{
	case 1:random(array, N); output(array, N); cout << endl; break;
	case 2:handswork(array, N); break;
	}
	for (int i = 0; i < N; i++)
	{
		if (i % 2 == 0)
		{
			Sumev += array[i];
		}
		else 
			Sumodd += array[i];
	}
	bool compare = (abs(Sumev) > abs(Sumodd));
	if (compare)
		cout << "Sum of elements in even places is more than sum in odd places" << endl;
	else 
		cout << "Sum of elements in odd places is more than sum in even places" << endl;

	for (int i = 0; i < N; i++)
	{
		gavg *= array[i];
	}
	gavg = pow(gavg, 1 * 1.0 / N );
	cout << "Geometrical average is equal " << gavg << endl;
}