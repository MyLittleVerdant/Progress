#define _CRT_SECURE_NO_WARNINGS
#include <iostream>
#include <fstream>
#include <string>
#include <ctime> 


using namespace std;

struct list
{
	char midname[20];
	char soname[20];
	char name[20];  
	int type;
};

void main()
{
	srand(time(0));
	struct list data[5];
	int i=0,min,temp,ind;
	
	FILE* file;
	file = fopen("file.txt", "rt");
	
	if (file)
	{
		while (!feof(file))
		{
			
			fscanf(file,"%s %s %s %d", &data[i].soname, &data[i].name, &data[i].midname, &data[i].type);
				// Обработка строки str
			i++;

		}

	}
	else cout << " File not exist" << endl;
	fclose(file);
	for (int j = 0; j < 5; j++)
	
		cout << data[j].soname << " " << data[j].name << " " << data[j].midname << " " << data[j].type << " " << endl;
	cout << endl;
	char temps[50], tempn[50], tempm[50];

	for (int j = 0; j < 5; j++)
	{
		min = INT_MAX;
		for (int i = j; i < 5; i++)
		{
			if (data[i].type < min)
			{
				min = data[i].type;
				ind = i;
			}

		}
		temp = data[j].type;
		data[j].type = min;
		data[ind].type = temp;

		strcpy(temps, data[j].soname);
		strcpy(tempn, data[j].name);
		strcpy(tempm, data[j].midname);

		strcpy(data[j].soname, data[ind].soname);
		strcpy(data[j].name, data[ind].name);
		strcpy(data[j].midname, data[ind].midname);

		strcpy(data[ind].soname, temps);
		strcpy(data[ind].name, tempn);
		strcpy(data[ind].midname, tempm);

		
	}


	for (int j = 0; j < 5; j++)

		cout << data[j].soname << " " << data[j].name << " " << data[j].midname << " " << data[j].type << " "<<endl;


	cout << "runtime = " << clock() / 1000.0 << endl;
	//3n^2 n^2 1.5n^2
}