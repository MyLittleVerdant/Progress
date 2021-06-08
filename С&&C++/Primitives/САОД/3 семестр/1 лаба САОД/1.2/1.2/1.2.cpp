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
	int i = 0, min, temp, ind;

	FILE* file;
	file = fopen("file.txt", "rt");

	if (file)
	{
		while (!feof(file))
		{

			fscanf(file, "%s %s %s %d", &data[i].soname, &data[i].name, &data[i].midname, &data[i].type);
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


	int count = 0;
	int  j, step;
	double tmp;
	for (step = 5 / 2; step > 0; step /= 2)
		for (i = step; i < 5; i++) {
			tmp = data[i].type;
			strcpy(temps, data[i].soname);
			strcpy(tempn, data[i].name);
			strcpy(tempm, data[i].midname);
			count++;
			for (j = i; j >= step; j -= step) {
				if (tmp < data[j - step].type)
				{
					data[j].type = data[j - step].type;
					strcpy(data[j].soname, data[j - step].soname);
					strcpy(data[j].name, data[j - step].name);
					strcpy(data[j].midname, data[j - step].midname);
				}
				else
					break;
			}
			data[j].type = tmp;
			strcpy(data[j].soname, temps);
			strcpy(data[j].name, tempn);
			strcpy(data[j].midname, tempm);
		}

	/*for (int i = 0; i < 4; i++)
	{
		if (data[i + 1].type < data[i].type)
		{
			temp = data[i].type;
			data[i].type = data[i+1].type;
			data[i + 1].type = temp;

			strcpy(temps, data[i].soname);
			strcpy(tempn, data[i].name);
			strcpy(tempm, data[i].midname);

			strcpy(data[i].soname, data[i+1].soname);
			strcpy(data[i].name, data[i+1].name);
			strcpy(data[i].midname, data[i+1].midname);

			strcpy(data[i+1].soname, temps);
			strcpy(data[i+1].name, tempn);
			strcpy(data[i+1].midname, tempm);



		}
	}*/

	for (int j = 0; j < 5; j++)

		cout << data[j].soname << " " << data[j].name << " " << data[j].midname << " " << data[j].type << " " << endl;


	cout << "runtime = " << clock() / 1000.0 << endl;
}