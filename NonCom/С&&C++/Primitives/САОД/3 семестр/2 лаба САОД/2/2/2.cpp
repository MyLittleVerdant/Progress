#define _CRT_SECURE_NO_WARNINGS

/*#include <iostream>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
using namespace std;
int main()
{
	setlocale(LC_ALL, "rus");
	FILE* fp = fopen("Text.txt", "rt");
	if (fp == NULL)
	{
		cout << "Невозможно найти файл" << endl;
		return 0;
	}
	char BufIn[2048];
	char BufOut[2048];
	int n;
	bool flag = false;
	while (!feof(fp))
	{
		n = fread(BufIn, sizeof(char), 2048, fp);
		BufIn[0] = toupper(BufIn[0]);
		int j = 0;
		int iNewLine = 0;
		int iStrNum = 0;
		for (int i = 0; i < n; i++)
		{
			if (iNewLine == 1) {
				if (iStrNum / 4 % 2 != 0) {
					
					for (int k = 0; k < 5; k++)
					{
						BufOut[j] = ' ';
						j++;
					}
				}
				BufOut[j] = toupper(BufIn[i]);
				iNewLine = 0;
			}
			else BufOut[j] = BufIn[i];
			if (BufIn[i] == '\n') {
				iNewLine = 1;
				iStrNum++;
				if (iStrNum % 4 == 0)
					flag = true;
			}
			
			j++;
			if (iStrNum != 0 && iStrNum % 4 == 0&&flag)
			{
				BufOut[j] = '\n';
				j++;
				flag = false;
			}
		}
		BufOut[j] = '\0';
		cout << BufOut;
		cout << "\n";
	}
	fclose(fp);;

	return 0;
}*/
#include <iostream>
#include <fstream>
using namespace std;
int main()
{
	setlocale(LC_ALL, "rus");
	int strnum = 0;
	char str[80];
	ifstream file("text.txt");
	while (!file.eof()) {
		if (strnum != 0 && strnum % 4 == 0)
		{
			cout << endl;
		}
		file.getline(str, 80);
		if (strnum / 4 % 2) {
			cout << "     ";
		}
		str[0] = toupper(str[0]);
		cout << str << endl;
		strnum++;
	}
	file.close();
	return 0;
}