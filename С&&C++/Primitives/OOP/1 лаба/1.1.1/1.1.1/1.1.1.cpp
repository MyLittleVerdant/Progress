#define _CRT_SECURE_NO_WARNINGS
#include <iostream>
#include <fstream>
#include <string>
using namespace std;

void random(int* m, int N = 10)
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

		m[i] = rand() % (B - A + 1) + A;
}

void handswork(int* m, int N = 10)
{
	for (int i = 0; i < N; i++)
		cin >> m[i];
	cout << endl;
}

void fromfile(int* m, int N)
{
	int i = 0;
	char name[20], buff[50];
	cout << "Enter the name and extension of the file to read " << endl;
	cin >> name;
	ifstream file(name);
	if (file)
	{
		while (i != N)
		{

			file >> buff;
			m[i] = atoi(buff);
			i++;


		}

	}
	else cout << " File not exist" << endl;
	file.close();
}

void output(int* m, int N)
{
	for (int i = 0; i < N; i++)
		cout << m[i] << " ";
}

void turn1(int* m, int N)
{
	int mid = N / 2;
	int temp;
	for (int i = 0; i < mid; i++)
	{
		temp = m[i];
		m[i] = m[N - i - 1];
		m[N - i - 1] = temp;
	}
}

void find6(int* m, int N)
{
	int maxeven = INT_MIN, minodd = INT_MAX, m1 = 0, m2 = 0, temp;
	for (int i = 0; i < N; i++)
	{
		if (m[i] > maxeven && m[i] % 2 == 0)
		{
			maxeven = m[i];
			m1 = i;
		}
		if (m[i] < minodd && m[i] % 2 == 1)
		{
			minodd = m[i];
			m2 = i;
		}
	}
	if (maxeven != INT_MIN && minodd != INT_MAX)
	{
		temp = m[m1];
		m[m1] = m[m2];
		m[m2] = temp;
	}
	else
		for (int i = 0; i < N; i++)
			m[i] = 0;


}

bool del(int* arr, int& length, int index)
{
	if (index < 0 || index > length) return false;
	for (int i = index; i < length; i++)
	{
		arr[i] = arr[i + 1];
	}
	length--;
	return true;
}
void mtt16(int* m, int* N)
{
	int a[10] = { 0 }, i, n, l = 0;
	for (int e = 0; e < *N; e++)
	{
		if (m[e] / 1000 > 0)
		{
			n = m[e];
			while (n > 0)
			{
				i = n % 10;
				a[i]++;
				n /= 10;
			}
			for (i = 0; i < 10; i++)
				if (a[i] > 0) l++;
			if (l > 3)
				del(m, *N, e);
		}
	}
}

void savefile(int* m, int N)
{
	ofstream file("save.txt");
	string s_str;
	for (int i = 0; i < N; i++)
	{
		s_str += to_string(m[i]);
		s_str += " ";
	}
	file << s_str;
	file.close();
}
void deleven11(int* m, int* N)
{
	for (int i = 0; i < *N; i++)
		if (m[i] % 2 == 0)
			del(m, *N, i);

}

void main()
{
	int N, * m, c, num;
	bool exit = false;
	do {
		cout << "Enter quantity of elements: ";
		cin >> N;
	} while (N < 1);
	m = new int[N];
	cout << "How to fill the array?" << endl << "1.Random" << endl << "2.Myself" << endl << "3.From file" << endl;
	do {
		cin >> c;
		if (c < 1 || c>3)
			cout << "Incorrect choise.Try again" << endl;
	} while (c < 1 || c>3);
	switch (c)
	{
	case 1:random(m, N); output(m, N); cout << endl; break;
	case 2:handswork(m, N); break;
	case 3:fromfile(m, N); break;
	}
	do {
		cout << "Enter 5 for an exit." << endl << "Choose number of a task: ";
		cin >> num;
		switch (num)
		{
		case 1:turn1(m, N); output(m, N); savefile(m, N); cout << endl; break;
		case 5:exit = true; break;
		case 6:find6(m, N); output(m, N); savefile(m, N); cout << endl; break;
		case 11:deleven11(m, &N); output(m, N); savefile(m, N); cout << endl; break;
		case 16:mtt16(m, &N); output(m, N); savefile(m, N); cout << endl; break;
		};
		cout << endl;

	} while (!exit);
	delete m;
}