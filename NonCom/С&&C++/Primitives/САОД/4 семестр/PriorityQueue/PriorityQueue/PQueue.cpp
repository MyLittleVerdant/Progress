#include "MaxHeap.h"


void main()
{
	Heap heap;
	int k;
	setlocale(LC_ALL, "rus");
	/*for (int i = 0; i < 4; i++) {
		cout << "������� ������� " << i + 1 << ": ";
		cin >> k;
		heap.addelem(k);
	}*/
	heap.Read("heap.txt");
	heap.outHeap();
	cout << endl;
	heap.out();
	cout <<endl<< heap.Peek();
	cout << endl << "������������ ������� : " << heap.getmax();
	cout << endl << "����� ���� : " << endl;
	heap.outHeap();
	cout << endl;
	heap.out();
	cout << endl << "������������ ������� : " << heap.getmax();
	cout << endl << "����� ���� : " << endl;
	heap.outHeap();
	cout << endl;
	heap.out();
}