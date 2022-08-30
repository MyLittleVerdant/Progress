#include "MaxHeap.h"


void main()
{
	Heap heap;
	int k;
	setlocale(LC_ALL, "rus");
	/*for (int i = 0; i < 4; i++) {
		cout << "Введите элемент " << i + 1 << ": ";
		cin >> k;
		heap.addelem(k);
	}*/
	heap.Read("heap.txt");
	heap.outHeap();
	cout << endl;
	heap.out();
	cout <<endl<< heap.Peek();
	cout << endl << "Максимальный элемент : " << heap.getmax();
	cout << endl << "Новая куча : " << endl;
	heap.outHeap();
	cout << endl;
	heap.out();
	cout << endl << "Максимальный элемент : " << heap.getmax();
	cout << endl << "Новая куча : " << endl;
	heap.outHeap();
	cout << endl;
	heap.out();
}