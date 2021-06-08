#include <vector>
#include <iostream>
#include <string> 
using namespace std;

class pick
{
	public:
	int lvl = 0;
	int weight = 0;
	int name = 1;
	int prev=-1;
	
};


void SearchPath(int a[80][80],int n, vector<pick> &Picks)
{
	for (int i = 0; i < n - 1; i++)//вершина
	{
		for (int j = i+1; j < n ; j++)//все смежные вершины
		{
			if (a[i][j] > 0&& Picks[j].weight< Picks[i].weight+ a[i][j])
			{
				Picks[j].lvl = Picks[i].lvl + 1;
				Picks[j].name = j+1;
				Picks[j].weight = Picks[i].weight + a[i][j];
				Picks[j].prev = i+1;
				
			}
		}
	}
}

void Results(vector<pick> Picks)
{
	int flag=100000,i;
	flag = Picks[Picks.size() - 1].lvl;
	i= Picks[Picks.size() - 1].name;
	string res;
	while (flag != -1)
	{
		res+= to_string(Picks[i-1].name);
		i = Picks[i - 1].prev;
		flag--;

	}
	cout << "Кратчайшая дуга ";
	for (int i = res.size() - 1; i >= 0; i--)
	{
		cout << res[i] << " ";
	}
	cout<< "с наибольшим весом "<< Picks[Picks.size() - 1].weight<<endl<<endl;
}

void main()
{
	int n, m, x, y,p, a[80][80];
	setlocale(LC_ALL, "rus");
	cout << "Введите количество вершин: ";
	cin >> n;
	vector<pick> Picks(n);
	cout << "Введите количество рёбер: ";
	cin >> m;
	for (int i = 0; i < n; i++)
		for (int j = 0; j < n; j++)
		{
			a[i][j] = 0;
		}
	cout << endl;
	
	for (int i = 0; i < m; i++)
	{
		cout << "Введите начало и конец ребра через пробел: " << endl;
		cin >> x >> y;
		cout << "Введите вес ребра: " << endl;
		cin >> p;
		a[x-1][y-1] =p;
		a[y-1][x-1] = p;

	}
	cout << endl;

	
	cout << "Матрица графа: " << endl;
	for (int i = 0; i < n; i++)
	{
		for (int j = 0; j <n; j++)
		{
			cout << a[i][j] << " ";
		}
		cout << endl<<endl;
	}
	SearchPath(a, n, Picks);
	Results(Picks);

}